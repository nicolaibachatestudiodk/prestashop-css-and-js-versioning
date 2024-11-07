<?php

class JavascriptManager extends JavascriptManagerCore
{
    protected function add($id, $fullPath, $position, $priority, $inline, $attribute, $server)
    {
        $priority = is_int($priority) ? $priority : self::DEFAULT_PRIORITY;
        $position = $this->getSanitizedPosition($position);
        $attribute = $this->getSanitizedAttribute($attribute);
        
        // Add versioning for local files
        if ('local' === $server && !$inline) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $fullPath)) {
                $version = filemtime($_SERVER['DOCUMENT_ROOT'] . $fullPath);
            } else {
                $version = '1';
            }
            $fullPath = $fullPath . '?v=' . $version;
        }

        // Determine URI and type based on server type
        if ('remote' === $server) {
            $uri = $fullPath;
            $type = 'external';
        } else {
            $uri = $this->getFQDN().parent::getUriFromPath($fullPath);
            $type = $inline ? 'inline' : 'external';
        }
        
        // Build Pixelcrush Proxied URL if enabled
        if (Module::IsEnabled('pixelcrush')) {
            $pixelcrush = Module::getInstanceByName('pixelcrush');
            if ($pixelcrush->isConfigured() && $pixelcrush->config->enable_statics) {
                $uri = $pixelcrush->cdnProxy(_PS_ROOT_DIR_ . $fullPath, $uri, true);
            }
        }
        
        // Add script to list with versioned URI
        $this->list[$position][$type][$id] = array(
            'id'        => $id,
            'type'      => $type,
            'path'      => $fullPath,
            'uri'       => $uri,
            'priority'  => $priority,
            'attribute' => $attribute,
            'server'    => $server,
        );
    }
    
    protected function getSanitizedPosition($position)
    {
        return in_array($position, $this->valid_position, true) ? $position : self::DEFAULT_JS_POSITION;
    }

    protected function getSanitizedAttribute($attribute)
    {
        return in_array($attribute, $this->valid_attribute, true) ? $attribute : '';
    }
}