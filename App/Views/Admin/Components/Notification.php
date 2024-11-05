<?php

namespace App\Views\Admin\Components;

use App\Views\BaseView;

class Notification extends BaseView
{
    public static function render($data = null)
    {


?>
        <div class="page-wrapper">
            <?php
            if (isset($_SESSION['success'])) :
                foreach ($_SESSION['success'] as $key => $value) :
            ?>

                    <div class="alert alert-success">
                        <strong><?= $value ?></strong>
                    </div>

            <?php
                endforeach;
            endif;
            ?>

            <?php
            if (isset($_SESSION['error'])) :
                foreach ($_SESSION['error'] as $key => $value) :
            ?>
                    <div class="alert alert-danger ">
                        <strong><?= $value ?></strong>
                    </div>
            <?php
                endforeach;

            endif;

            ?>
        </div>

<?php
    }
}

?>