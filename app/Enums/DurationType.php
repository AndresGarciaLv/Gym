<?php
namespace App\Enums;

enum DurationType:string
{
    case DIARIA = 'Diaria';
    case SEMANAL = 'Semanal';
    case MENSUAL = 'Mensual';
    case ANUAL = 'Anual';
}
