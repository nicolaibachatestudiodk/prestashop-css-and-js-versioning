<?php
class StylesheetManager extends StylesheetManagerCore
{
    protected function add($id, $fullPath, $media, $priority, $inline, $server)
    {
        if ('local' === $server && !$inline) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $fullPath)) {
                $version = filemtime($_SERVER['DOCUMENT_ROOT'] . $fullPath);
            } else {
                $version = '1';
            }

            $fullPath = $fullPath . '?v=' . $version;
        }

        parent::add($id, $fullPath, $media, $priority, $inline, $server);
    }
}