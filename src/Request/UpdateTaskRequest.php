<?php

namespace App\Request;

use App\Enum\Status;

class UpdateTaskRequest
{
    public function __construct(
        private string $title = '',
        private string $description = '',
        private Status $status = Status::New,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
}
