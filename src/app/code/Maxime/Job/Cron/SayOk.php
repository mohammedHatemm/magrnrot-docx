<?php

namespace Maxime\Job\Cron;

use Psr\Log\LoggerInterface;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem\DirectoryList;

class SayOk
{
  protected $file;
  protected $directoryList;

  public function __construct(
    File $file,
    DirectoryList $directoryList
  ) {
    $this->file = $file;
    $this->directoryList = $directoryList;
  }

  public function execute()
  {

    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] ok from cron\n";
    $logPath = $this->directoryList->getPath('log') . '/okLOG.log';

    // Append message to the file
    if ($this->file->isExists($logPath)) {
      $this->file->filePutContents($logPath, $logMessage, FILE_APPEND);
    } else {
      $this->file->filePutContents($logPath, $logMessage);
    }

    return $this;
  }
}
