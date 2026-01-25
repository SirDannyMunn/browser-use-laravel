<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\PresignedUrl;
use BrowserUseLaravel\DataTransferObjects\TaskOutputFile;

class FilesResource extends Resource
{
    /**
     * Generate a presigned URL for uploading files to an agent session.
     *
     * POST /files/sessions/{session_id}/presigned-url
     *
     * @param string $sessionId The session ID (UUID)
     * @param string $fileName The name of the file to upload
     * @param string $contentType The MIME type of the file
     * @param int $sizeBytes Size of the file in bytes
     */
    public function getAgentSessionUploadUrl(
        string $sessionId,
        string $fileName,
        string $contentType,
        int $sizeBytes,
    ): PresignedUrl {
        $response = $this->http->post("/files/sessions/{$sessionId}/presigned-url", [
            'fileName' => $fileName,
            'contentType' => $contentType,
            'sizeBytes' => $sizeBytes,
        ]);
        return PresignedUrl::fromArray($response);
    }

    /**
     * Generate a presigned URL for uploading files to a browser session.
     *
     * POST /files/browsers/{session_id}/presigned-url
     *
     * @param string $sessionId The browser session ID (UUID)
     * @param string $fileName The name of the file to upload
     * @param string $contentType The MIME type of the file
     * @param int $sizeBytes Size of the file in bytes
     */
    public function getBrowserSessionUploadUrl(
        string $sessionId,
        string $fileName,
        string $contentType,
        int $sizeBytes,
    ): PresignedUrl {
        $response = $this->http->post("/files/browsers/{$sessionId}/presigned-url", [
            'fileName' => $fileName,
            'contentType' => $contentType,
            'sizeBytes' => $sizeBytes,
        ]);
        return PresignedUrl::fromArray($response);
    }

    /**
     * Get a presigned download URL for a task's output file.
     *
     * GET /files/tasks/{task_id}/output-files/{file_id}
     *
     * @param string $taskId The task ID (UUID)
     * @param string $fileId The file ID (UUID)
     */
    public function getTaskOutputFileUrl(string $taskId, string $fileId): TaskOutputFile
    {
        $response = $this->http->get("/files/tasks/{$taskId}/output-files/{$fileId}");
        return TaskOutputFile::fromArray($response);
    }
}
