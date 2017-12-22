<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

trait FileManagement
{
    /**
     * @return string
     */
    protected function getDiskDriver()
    {
        return 'local';
    }

    /**
     * @return string
     */
    protected function getGlobalPathPrefix()
    {
        return 'files';
    }

    /**
     * @return string
     */
    protected function getSubPathPrefix()
    {
        return date('Y') . '/' . date('m');
    }

    /**
     * @return string
     */
    protected function getFilePrefix($id = 777777)
    {
        return $this->getGlobalPathPrefix() . '/assets/' . $this->getSubPathPrefix() . '/' . intval($id);
    }

    /**
     * @return int
     */
    protected function getMaxFileSizeInKB()
    {
        return 5120; // 5 MB
    }

    /**
     * @return string
     */
    protected function getMimeTypes()
    {
        return 'jpeg,bmp,png,pdf,doc,docx,txt,log';
    }

    /**
     * @param $filePath
     * @param array $params
     * @return string
     */
    protected function getFileNameForDownload($filePath, $params = [])
    {
        $arrExtension = explode('.', $filePath);

        $extension = '';
        if (count($arrExtension) > 1) {
            $extension = '.' . $arrExtension[count($arrExtension) - 1];
        }

        $str = '';
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $str .= '_' . $value;
            }
        }

        return date('Y-m-d_His') . $str . $extension;
    }

    /**
     * @param $requestFileHandle
     * @param $filePath
     * @return mixed
     */
    protected function uploadFile($requestFileHandle, $filePath)
    {
        return $requestFileHandle->store($filePath, $this->getDiskDriver());
    }

    /**
     * @param $fileName
     * @param $filePath
     * @return mixed
     */
    protected function downloadFile($fileName, $filePath)
    {
        return Storage::disk($this->getDiskDriver())->download($filePath, $fileName);
    }

    /**
     * @param $filePath
     * @return mixed
     */
    protected function deleteFile($filePath)
    {
        return Storage::disk($this->getDiskDriver())->delete($filePath);
    }
}