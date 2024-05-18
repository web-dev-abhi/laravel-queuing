<?php

namespace App\Listeners;

use App\Events\CsvUploadedEvent;
use App\Jobs\InsertDataIntoDB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;

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
      $columns = fgetcsv($handle, 0);
      #1
      // while (($row = fgetcsv($handle, 0, ',')) !== false) {
      //   $currentBatch[] = $row;
      //   InsertDataIntoDB::dispatch($columns, $row);
      // }

      #2
      $batch = Bus::batch([])->dispatchAfterResponse();
      while (($row = fgetcsv($handle, 0, ',')) !== false) {
        $batch->add(new InsertDataIntoDB($columns, $row));
      }
    }
  }
}
