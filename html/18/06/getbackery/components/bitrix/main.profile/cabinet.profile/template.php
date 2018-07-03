<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if (!CModule::IncludeModule('dirix.megatron'))
	die('Не удалось подключить модуль кэшбэк-сервиса');

if (0 < strlen($arResult["strProfileError"])) 
	echo CMegatronTools::GetNotification('error', $arResult["strProfileError"]);

if ($arResult['DATA_SAVED'] == 'Y')
	echo CMegatronTools::GetNotification('success', GetMessage('PROFILE_DATA_SAVED'));
?>
<div class="col-md-6 col-md-offset-3">

<script type="text/javascript">
<!--
var opened_sections = [<?
$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
if (strlen($arResult["opened"]) > 0)
{
	echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
}
else
{
	$arResult["opened"] = "reg";
	echo "'reg'";
}
?>];
//-->

var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
</script>
<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
<?=$arResult["BX_SESSION_CHECK"]?>
<input type="hidden" name="lang" value="<?=LANG?>" />
<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

<div id="user_div_reg">

	<?
	if($arResult["ID"]>0)
	{
	?>
		<?
		if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
		{
		?>
		<div class="form-group">
			<label><?=GetMessage('LAST_UPDATE')?></label>
			<input type="text" class="form-control" value="<?=$arResult["arUser"]["TIMESTAMP_X"]?>" disabled>
		</div>
		<?
		}
		?>
		<?
		if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
		{
		?>
		<div class="form-group">
			<label><?=GetMessage('LAST_LOGIN')?></label>
			<input type="text" class="form-control" value="<?=$arResult["arUser"]["LAST_LOGIN"]?>" disabled>
		</div>
		<?
		}
		?>
	<?
	}
	?>
	<div class="form-group">
		<label><?=GetMessage('main_profile_title')?></label>
		<input type="text" name="TITLE" class="form-control" value="<?=$arResult["arUser"]["TITLE"]?>">
	</div>
	<div class="form-group">
		<label><?=GetMessage('NAME')?></label>
		<input class="form-control" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>">
	</div>	
	<div class="form-group">
		<label><?=GetMessage('LAST_NAME')?></label>
		<input class="form-control" type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>">
	</div>	
	<div class="form-group">
		<label><?=GetMessage('SECOND_NAME')?></label>
		<input class="form-control" type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>">
	</div>	
	<div class="form-group">
		<label><?=GetMessage('EMAIL')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
		<input class="form-control" type="text" name="EMAIL" maxlength="50" value="<?=$arResult["arUser"]["EMAIL"]?>">
	</div>	
	<div class="form-group">
		<label><?=GetMessage('LOGIN')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></label>
		<input class="form-control" type="text" name="LOGIN" maxlength="50" value="<?=$arResult["arUser"]["LOGIN"]?>">
	</div>	

<?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
	<div class="form-group">
		<label><?=GetMessage('NEW_PASSWORD_REQ')?></label>
		<input class="form-control" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off">
	</div>	

<?if($arResult["SECURE_AUTH"]):?>
	<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
		<div class="bx-auth-secure-icon"></div>
	</span>
	<noscript>
		<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
			<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
		</span>
	</noscript>
<script type="text/javascript">
document.getElementById('bx_auth_secure').style.display = 'inline-block';
</script>
<?endif?>
	<div class="form-group">
		<label><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
		<input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off">
	</div>
<?endif?>
<?if($arResult["TIME_ZONE_ENABLED"] == true):?>
	<tr>
		<td colspan="2" class="profile-header"><?echo GetMessage("main_profile_time_zones")?></td>
	</tr>
	<tr>
		<td><?echo GetMessage("main_profile_time_zones_auto")?></td>
		<td>
			<select class="form-control" name="AUTO_TIME_ZONE" onchange="this.form.TIME_ZONE.disabled=(this.value != 'N')">
				<option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
				<option value="Y"<?=($arResult["arUser"]["AUTO_TIME_ZONE"] == "Y"? ' SELECTED="SELECTED"' : '')?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
				<option value="N"<?=($arResult["arUser"]["AUTO_TIME_ZONE"] == "N"? ' SELECTED="SELECTED"' : '')?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><?echo GetMessage("main_profile_time_zones_zones")?></td>
		<td>
			<select class="form-control" name="TIME_ZONE"<?if($arResult["arUser"]["AUTO_TIME_ZONE"] <> "N") echo ' disabled="disabled"'?>>
			<?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
				<option value="<?=htmlspecialcharsbx($tz)?>"<?=($arResult["arUser"]["TIME_ZONE"] == $tz? ' SELECTED="SELECTED"' : '')?>><?=htmlspecialcharsbx($tz_name)?></option>
			<?endforeach?>
			</select>
		</td>
	</tr>
<?endif?>

</div>

<?if($arResult["IS_ADMIN"]):?>
	<div class="profile-link profile-user-div-link"><a title="<?=GetMessage("USER_SHOW_HIDE")?>" href="javascript:void(0)" onclick="SectionClick('admin')"><?=GetMessage("USER_ADMIN_NOTES")?></a></div>
	<div id="user_div_admin" class="profile-block-<?=strpos($arResult["opened"], "admin") === false ? "hidden" : "shown"?>">
	<table class="data-table profile-table">
		<thead>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?=GetMessage("USER_ADMIN_NOTES")?>:</td>
				<td><textarea cols="30" rows="5" name="ADMIN_NOTES"><?=$arResult["arUser"]["ADMIN_NOTES"]?></textarea></td>
			</tr>
		</tbody>
	</table>
	</div>
<?endif;?>

	<p><?=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>" />
		&nbsp;&nbsp;
		<input class="btn btn-danger" type="reset" value="<?=GetMessage('MAIN_RESET');?>">
	</div>
</form>
<?
if($arResult["SOCSERV_ENABLED"])
{
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
			"SHOW_PROFILES" => "Y",
			"ALLOW_DELETE" => "Y"
		),
		false
	);
}
?>
</div>