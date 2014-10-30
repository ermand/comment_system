<?php

require 'vendor/autoload.php';

if (isset($_POST['submit']))
{
    $message = '';
    $messageType = 'danger';

    /**
     * Try to create new customer with POST input data.
     */
    try {
        $customer = (new \App\Customer())->create([
            'first_name'    => $_POST['first_name'],
            'last_name'     => $_POST['last_name'],
            'birthdate'     => $_POST['birthdate'],
            'personal_id'   => $_POST['personal_id'],
            'customer_type' => $_POST['customer_type']
        ]);
    } catch (Exception $e) {
        throw new InvalidArgumentException($e->getMessage());
    }

    /**
     * If during customer create has been as error, such as validation, assign them to $message.
     */
    if ($customer->hasError())
    {
        foreach ($customer->getErrors() as $error)
        {
            $message .= " - " . $error . "<br>";
        }
    }
    else
    {
        /**
         * Get contract_type and based on that create PrepaidContract or PostpaidContract.
         */
        if ($_POST['contract_type'] == 'prepaid')
        {
            $contract= (new \App\PrepaidContract())->create([
                'id'                  => 1,
                'msisdn'              => $_POST['msisdn'],
                'sim'                 => $_POST['msisdn'],
                'tariff_plan'         => $_POST['tariff_plan'],
                'supplementary_offer' => $_POST['supplementary_offer']
            ], $customer);
        }
        else
        {
            $contract= (new \App\PostpaidContract())->create([
                'id'          => 1,
                'msisdn'      => $_POST['msisdn'],
                'sim'         => $_POST['msisdn'],
                'tariff_plan' => $_POST['tariff_plan'],
                'discount'    => $_POST['discount']
            ], $customer);
        }

        /**
         * If there are any validation errors, assign them to $message.
         */
        if ($contract->hasError())
        {
            foreach ($contract->getErrors() as $error)
            {
                $message .= " - " . $error . "<br>";
            }
        }
        else
        {
            $messageType = 'success';
            $message = 'Contract was successfully created.';
        }
    }
}

/**
 * Get current value of POST based on input name.
 *
 * @param $input
 * @return string
 */
function getCurrentValue($input)
{
    return isset($_POST[$input]) ? $_POST[$input] : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sample Code - New Contract</title>

    <!-- Bootstrap core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">

    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h3>New Contract Form</h3>

        <form action="" method="post" class="form-horizontal">

            <?php
            // If there are any messages then display them on the page.
            if (isset($message) && $message != '')
            { ?>
                <div class="alert alert-block alert-<?php echo $messageType ?>">
                    <button type="button" class="close" data-dismiss="alert"><i class="icon icon-remove"></i></button>
                    <i class="icon-warning-sign orange"></i> <strong>Message!</strong>
                    <ul id="form-errors">
                        <?php echo $message; ?>
                    </ul>
                </div>
            <?php
            } ?>

            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="first_name">First Name</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="text" name="first_name" placeholder="First Name" class="form-control" value="<?php echo getCurrentValue('first_name'); ?>" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="last_name">Last Name</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="text" name="last_name" placeholder="Last Name" class="form-control" value="<?php echo getCurrentValue('last_name'); ?>" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="birthdate">Birthdate</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="text" name="birthdate" placeholder="Birthdate" class="form-control" value="<?php echo getCurrentValue('birthdate'); ?>" required/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="personal_id">Personal Id</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="text" name="personal_id" placeholder="Personal Id" class="form-control" value="<?php echo getCurrentValue('personal_id'); ?>" required/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="customer_type">Customer Type</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <select name="customer_type" class="form-control">
                        <option value="individual">Individual</option>
                        <option value="business">Business</option>
                    </select>
                </div>
            </div>

            <hr/>
            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="contract_type">Contract Type</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <select name="contract_type" class="form-control" id="contract_type">
                        <option value="prepaid">Prepaid</option>
                        <option value="postpaid">Postpaid</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="tariff_plan">Tariff Plan</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="text" name="tariff_plan" placeholder="Tariff Plan" class="form-control" value="<?php echo getCurrentValue('tariff_plan'); ?>" required/>
                </div>
            </div>

            <div class="form-group" id="supplementary_offer">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="supplementary_offer">Supplementary Offer</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="text" name="supplementary_offer" placeholder="Supplementary Offer" class="form-control" value="<?php echo getCurrentValue('supplementary_offer'); ?>" />
                </div>
            </div>

            <div class="form-group" id="discount">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="discount">Discount %</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="number" name="discount" placeholder="Discount %" class="form-control" value="<?php echo getCurrentValue('discount'); ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="msisdn">Cell Number</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="text" name="msisdn" placeholder="Cell Number" class="form-control" value="<?php echo getCurrentValue('msisdn'); ?>" required/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-4 col-xs-4 control-label" for="sim">SIM Card</label>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6">
                    <input type="text" name="sim" placeholder="SIM Card" class="form-control" value="<?php echo getCurrentValue('sim'); ?>" required/>
                </div>
            </div>

            <hr/>

            <div class="form-group center">
                <div class="col-lg-offset-4 col-lg-6">
                    <button class="btn btn-info ladda-button" name="submit" type="submit" data-style="expand-right">
                        <i class="icon-ok bigger-110"></i>
                        <span class="ladda-label">Submit</span>
                    </button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>

        </form>
    </div>
</div> <!-- /container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#supplementary_offer').show();
        $('#discount').hide();

        $('#contract_type').change(function () {
            var choice = $(this).val();
            if ( choice == 'postpaid' ) {
                $('#supplementary_offer').hide();
                $('#discount').show();
            } else {
                $('#supplementary_offer').show();
                $('#discount').hide();
            }
        });

    });
</script>
</body>
</html>
