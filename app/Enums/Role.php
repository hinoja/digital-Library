<?php 

namespace App\Enums;

enum Role:String {
   
    case ADMIN='administrator';
    case STUDENT='student';
    case TEACHER ='teacher';

}