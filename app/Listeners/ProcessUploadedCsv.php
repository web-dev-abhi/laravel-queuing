<?php

namespace App\Listeners;

use App\Events\CsvUploadedEvent;
use App\Jobs\InsertDataIntoDB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessUploadedCsv
{
  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(CsvUploadedEvent $event): void
  {
    if (($handle =  fopen(public_path($event->path), 'r')) !== false) {
      $batchSize = 100;
      $currentBatch = [];
      $rowCount = 0;
      $columns = fgetcsv($handle, 0);

      while (($row = fgetcsv($handle, 0, ',')) !== false) {
        $currentBatch[] = $row;
        $rowCount++;
        InsertDataIntoDB::dispatch($columns, $row);
        // If the batch size is reached, process the current batch
        if ($rowCount % $batchSize == 0) {
          // $this->processBatch($currentBatch);
          // Reset the current batch
          // $currentBatch = [];
        }
      }

      // Process any remaining rows in the current batch
      if (!empty($currentBatch)) {
        // $this->processBatch($currentBatch);
      }
      // Close the file
      // fclose($handle);
    } else {
      // Handle error if the file cannot be opened
      throw new \Exception('Unable to open file.');
    }
  }
}
