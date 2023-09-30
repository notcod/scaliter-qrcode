<?php

namespace Scaliter;

use \PragmaRX\Google2FA\Google2FA as Google2FA;
use \CodeItNow\BarcodeBundle\Utils\QrCode as BarCode;

class QrCode
{
    static function Key()
    {
        $Google2FA = new Google2FA();
        return $Google2FA->generateSecretKey();
    }
    static function Validate($Input, $Code)
    {
        $Google2FA = new Google2FA();
        return $Google2FA->verifyKey($Input, $Code);
    }
    static function URL($Company, $Email, $Code)
    {
        $Google2FA = new Google2FA();
        return $Google2FA->getQRCodeUrl($Company, $Email, $Code);
    }
    static function Img($Company, $Email, $Code)
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . self::URL($Company, $Email, $Code);
    }
    public static function xURL($Company, $Email, $Code){
        return "otpauth://totp/$Company:$Email?secret=$Code";
    }
    static function QrCode($Data)
    {
        $qrCode = new BarCode();
        $qrCode
            ->setText($Data)
            ->setSize(200)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setImageType(BarCode::IMAGE_TYPE_PNG);
        return 'data:' . $qrCode->getContentType() . ';base64,' . $qrCode->generate();
    }
}
