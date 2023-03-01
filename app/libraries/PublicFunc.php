<?php

class PublicFunc
{
    public function styling($className = "")
    {
        echo "<style>." . $className .
            "{
                color: #130f40 !important;
                background: #ffffff !important;
                border-radius: 25px;
             
                padding: 6px 12px !important;
             }
             </style>";
    }
}
