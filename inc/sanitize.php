<?php
$regextext = '/^[A-Za-ÿ]+((\s)?((\'|\-|\.)?([A-Za-z])+))*$/m';
$regexaddress = '/^\d{1,3}\s\w+\s\w+(\s\w+)*\s\d{5}\s\w+$/';
$regexdate = '/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3[01])$/';
$contact = [];
$first_name = '';
$last_name = '';
$birth_date = '';
$user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$options = array(
    'first_name' => FILTER_SANITIZE_STRING,
    'last_name' => FILTER_SANITIZE_STRING,
    'birth_date' => FILTER_SANITIZE_STRING,
    'incomes' => FILTER_SANITIZE_NUMBER_FLOAT,
    'inc_cat_id' => FILTER_SANITIZE_NUMBER_INT,
    'exp_label' => FILTER_SANITIZE_STRING
);
$errors = array();
$posts = filter_input_array(INPUT_POST, $options);
if (!empty($_POST)) {
    extract($_POST);
    if (empty($first_name)) {
        $errors['firstname'] = "Le champ est requis";
    } elseif (!preg_match($regextext, $first_name)) {
        $errors['firstname'] = "Le format n'est pas correct";
    }
    if (empty($last_name)) {
        $errors['lastname'] = "Le champ est requis";
    } elseif (!preg_match($regextext, $last_name)) {
        $errors['lastname'] = "Le format n'est pas correct";
    }
    if (empty($birth_date)) {
        $errors['birthdate'] = "Le champ est requis";
    } elseif (!preg_match($regexdate, $birth_date)) {
        $errors['birthdate'] = "Le format n'est pas correct";
    }
    if (isset($income)) {
        if (!filter_var($income, FILTER_VALIDATE_FLOAT)) {
            if($income != NULL) {
                $errors['income'] = "Le format n'est pas correct";
            }   
        }
        else {
            $incomes = $income;
        }

    }
    if (isset($expense)) {
        if (!filter_var($expense, FILTER_VALIDATE_FLOAT)) {
            if($expense != NULL) {
                $errors['expense'] = "Le format n'est pas correct";
            }
        }
        else {
            $expenses = $expense;
        }
    }
    if (isset($inc_cat_id)) {
        if (!filter_var($inc_cat_id, FILTER_VALIDATE_INT)) {
            if($inc_cat_id != NULL) {
                $errors['inc_cat_id'] = "Le format n'est pas correct";
            }   
        }
        else {
            $inc_cat_ids = $inc_cat_id;
        }

    }
    if (isset($exp_label)) {
        if (!preg_match($regextext, $exp_label)) {
            if($exp_label != NULL) {
                $errors['exp_label'] = "Le format n'est pas correct.";
            }   
        }
        else {
            $exp_labels = $exp_label;
        }
    }
    if (empty($errors)) {
        // var_dump($_SERVER);
        if ($_SERVER['SCRIPT_NAME'] == '/add-user.php') {
            if (addUser($first_name, $last_name, $birth_date)) {
                header('location:index.php');
                exit();
            }
        } else if ($_SERVER['SCRIPT_NAME'] == '/modify.php') {
            if (modifyUser($first_name, $last_name, $birth_date, $user_id)) {
                if(isset($incomes)) {
                    createUserIncome($user_id, $incomes, $inc_cat_id);
                }
                if(isset($expenses)) {
                    if(isset($exp_labels)) {
                        createUserExpense($user_id, $expenses, $exp_labels);
                    }
                }
                header('location:user.php?user_id='.$user_id);
                exit(); 
            }
        } else if ($_SERVER['SCRIPT_NAME'] == '/modify-income.php') {
            if(isset($incomes)) {
                modifyIncome($incomes, $inc_cat_ids);
            }
            header('location:user.php?user_id='.$user_id.'&inc_id'.$_GET['inc_id']);
            exit();
        }
    }
}