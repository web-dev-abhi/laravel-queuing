<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertDataIntoDB implements ShouldQueue
{
  use Dispatchable, Batchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */
  public function __construct(public  $columns, public $data)
  {
    // dd($this->data, $this->columns);
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $data = [];
    for ($i = 0; $i < count($this->columns); $i++) {
      $data[$this->columns[$i]] = $this->data[$i];
    }
    User::create($data);
  }
}
