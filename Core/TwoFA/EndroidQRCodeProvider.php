<?php

namespace Core\TwoFA;

use RobThree\Auth\Providers\Qr\IQRCodeProvider;

class EndroidQRCodeProvider implements IQRCodeProvider
{
    public function getQRCodeImage(string $qrText, int $size): string
    {
        $url = 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size . '&data=' . urlencode($qrText);
        return file_get_contents($url);
    }

    public function getMimeType(): string
    {
        return 'image/png';
    }
}
