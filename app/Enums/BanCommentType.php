<?php

namespace App\Enums;

enum BanCommentType: string
{
    case USER_PAUSE = '장기 미접속 신청';
    case APPLICATION_ACCEPT = '가입 승인';
}
