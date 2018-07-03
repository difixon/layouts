<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (isset($_POST['phone_number']) && '' != $_POST['phone_number'])
{
    $phone_number = '+'.intval($_POST['phone_number']);

    if (0 === strpos($phone_number, '+8') && 12 == strlen($phone_number))
        $phone_number = '+7'.substr($phone_number, 2);

    $arUser = CUser::GetList(($by="personal_country"), ($order="desc"), array('PERSONAL_PHONE' => $phone_number))->Fetch();

    if (0 < $arUser['ID']) {
        $sError .= CMegatronTools::GetNotification('error', 'Ошибка!', 'Указанный номер телефона уже зарегистрирован в системе', false, false);

    } else
    {
        $sms_code = rand(10000, 99999);

        $USER->SetParam('CONFIRMATION_PHONE', $phone_number);
        $USER->SetParam('CONFIRMATION_CODE', $sms_code);
        $USER->SetParam('CONFIRMATION_STATUS', 'N');

        $smsru = new CMegatronSMS();
        $sms = new stdClass();
        $sms->to = $phone_number;
        $sms->text = 'Проверочный код: '.$sms_code;

        $smsResult = $smsru->send_one($sms);

        if ('OK' != $smsResult->status)
            $sError .= CMegatronTools::GetNotification('danger', '', 'Ошибка при отправке сообщения с проверочным кодом', false, false);
    }

} elseif (isset($_POST['sms_confirmation_code']) && '' != $_POST['sms_confirmation_code'])
    if ($_POST['sms_confirmation_code'] == $USER->GetParam('CONFIRMATION_CODE'))
        $USER->SetParam('CONFIRMATION_STATUS', 'Y');


?>
<div class="col-md-6 col-md-offset-3">

<?=$sError;?>

<?if($USER->IsAuthorized()):?>
<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

<?else:?>
<?
if (count($arResult["ERRORS"]) > 0)
{
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0) 
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	ShowError(implode("<br />", $arResult["ERRORS"]));
}
?>

    <?if (!empty($USER->GetParam('CONFIRMATION_STATUS')) && 'Y' == $USER->GetParam('CONFIRMATION_STATUS')):?>
        <?=CMegatronTools::GetNotification('success', '', 'Номер телефона успешно подтвержден. <br>Для завершения регистрации заполните оставшиеся поля', false, false);?>

        <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
            <input id="field_LOGIN" type="hidden" name="REGISTER[LOGIN]" value="" />
        <?
        if($arResult["BACKURL"] <> ''):
        ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?
        endif;
        ?>

        <table>
            <tbody>
        <?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
            <?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>

            <?else:?>
                <div class="form-group">

                <?if ('LOGIN' != $FIELD):?>
                    <label><?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?></label>
                <?endif;?>

                <?if('EMAIL' == $FIELD &&  "Y" == $arResult["USE_EMAIL_CONFIRMATION"]):?>
                    <p><?=GetMessage("REGISTER_EMAIL_WILL_BE_SENT");?></p>
                <?endif?>

                    <?
                    switch ($FIELD)
                    {
                        case "LOGIN":
                            break;

                        case "PASSWORD":
                            ?>
                            <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
                            <input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="form-control" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" />

                            <?
                            break;
                        case "CONFIRM_PASSWORD":
                            ?><input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="form-control" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" /><?
                            break;

                        case "PERSONAL_PHONE":
                            ?><input size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$USER->GetParam('CONFIRMATION_PHONE')?>" class="form-control" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" readonly />

                            <?
                            break;

                        case "PERSONAL_GENDER":
                            ?><select name="REGISTER[<?=$FIELD?>]" class="form-control" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>">
                            <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                            <option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
                            <option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
                            </select><?
                            break;

                        case "PERSONAL_COUNTRY":
                        case "WORK_COUNTRY":
                            ?><select name="REGISTER[<?=$FIELD?>]"><?
                            foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
                            {
                                ?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
                                <?
                            }
                            ?></select><?
                            break;

                        case "PERSONAL_PHOTO":
                        case "WORK_LOGO":
                            ?><input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" class="form-control" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" /><?
                            break;

                        case "PERSONAL_NOTES":
                        case "WORK_NOTES":
                            ?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]" class="form-control" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>"><?=$arResult["VALUES"][$FIELD]?></textarea><?
                            break;
                        default:
                            if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;
                            ?><input size="30" type="text" id="field_<?=$FIELD?>" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" class="form-control" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" /><?
                            if ($FIELD == "PERSONAL_BIRTHDAY")
                                $APPLICATION->IncludeComponent(
                                    'bitrix:main.calendar',
                                    '',
                                    array(
                                        'SHOW_INPUT' => 'N',
                                        'FORM_NAME' => 'regform',
                                        'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
                                        'SHOW_TIME' => 'N'
                                    ),
                                    null,
                                    array("HIDE_ICONS"=>"Y")
                                );
                            ?><?
                    }?>
                </div>
            <?endif?>
        <?endforeach?>
        <?// ********************* User properties ***************************************************?>
        <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
            <tr><td colspan="2"><?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></td></tr>
            <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
            <tr><td><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;?></td><td>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
            <?endforeach;?>
        <?endif;?>
        <?// ******************** /User properties ***************************************************?>
        <?
        /* CAPTCHA */
        if ($arResult["USE_CAPTCHA"] == "Y")
        {
            ?>
                <div class="form-group">
                    <label><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></label>

                    <div class="row">
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="captcha_word" maxlength="50" value="" placeholder="<?=GetMessage("REGISTER_CAPTCHA_PROMT")?>">
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                            <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        </div>
                    </div>

                </div>
            <?
        }
        /* !CAPTCHA */
        ?>
            </tbody>

            <div class="right">
                <input class="button color button-3d rounded effect text-dark" type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
            </div>

        </table>

        </form>

    <script type="text/javascript">
        $('#field_EMAIL').keyup(function () {
            var email = $(this).val();
            $('#field_LOGIN').val(email);
        });
    </script>

    <?else:?>
        <form action="" method="post">

        <?if (!empty($USER->GetParam('CONFIRMATION_CODE')) && 0 < strlen($USER->GetParam('CONFIRMATION_CODE'))):?>
            <?=CMegatronTools::GetNotification('success', '', 'Сообщение с проверочным кодом отправлено на номер '.$USER->GetParam('CONFIRMATION_PHONE'), false, false);?>
            <div class="form-group">
                <label>Код подтверждения из SMS:</label>
                <input class="form-control" type="text" name="sms_confirmation_code" value="" placeholder="Введите проверочный код из SMS">
            </div>

            <div class="right">
                <button class="button color button-3d rounded effect text-dark" type="submit">
                    <span>Проверить</span>
                </button>
            </div>
        <?else:?>
            <?=CMegatronTools::GetNotification('warning', '', 'На указанный номер телефона будет отправлено SMS-сообщение с проверочным кодом для подтверждения', false, false);?>
            <div class="form-group">
                <label>Номер телефона в международном формате:</label>
                <input class="form-control" type="text" name="phone_number" value="" placeholder="Введите номер телефона">
            </div>

            <div class="right">
                <button class="button color button-3d rounded effect text-dark" type="submit">
                    <span>Далее</span>
                </button>
            </div>
        <?endif;?>

        </form>
    <?endif;?>
<?endif?>
</div>