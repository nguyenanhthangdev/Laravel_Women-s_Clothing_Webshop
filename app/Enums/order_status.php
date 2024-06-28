<?php

namespace App\Enums;

class order_status
{
    const ORDERED = 'ordered';
    const PROCESSING = 'processing';
    const SHIPPED = 'shipped';
    const DELIVERED = 'delivered';
    const CANCELLED = 'cancelled';

    public static function getStatus()
    {
        return [
            self::ORDERED,
            self::PROCESSING,
            self::SHIPPED,
            self::DELIVERED,
            self::CANCELLED,
        ];
    }

    public static function getStatusText($status)
    {
        switch ($status) {
            case self::ORDERED:
                return 'Đã đặt hàng';
            case self::PROCESSING:
                return 'Đang xử lý';
            case self::SHIPPED:
                return 'Đang giao hàng';
            case self::DELIVERED:
                return 'Đã giao hàng';
            case self::CANCELLED:
                return 'Đã hủy';
            default:
                return 'Không xác định';
        }
    }
}
