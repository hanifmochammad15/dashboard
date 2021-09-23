<?php
require('../next/connection_next.php');
$cabang=" AND b. NAME IN (
                    'Sales::POS DIRECT::Pos JKP',
                    'Sales::POS DIRECT::HO Sharia',
                    'Sales::POS DIRECT::HO KONVEN'

                )";

include 'dashboard_cabang.php' ;

