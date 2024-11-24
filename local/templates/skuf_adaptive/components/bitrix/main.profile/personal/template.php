<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if ($arResult["SHOW_SMS_FIELD"]) {
    CJSCore::Init('phone_auth');
}
?>

<div class="bx-auth-profile">

    <? ShowError($arResult["strProfileError"]); ?>
    <?
    if ($arResult['DATA_SAVED'] == 'Y')
        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    ?>

    <script type="text/javascript">

        let opened_sections = [<?
            $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"] . "_user_profile_open"];
            $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
            if ($arResult["opened"] <> '') {
                echo "'" . implode("', '", explode(",", $arResult["opened"])) . "'";
            } else {
                $arResult["opened"] = "reg";
                echo "'reg'";
            }
            ?>];

        const cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
    </script>

    <form method="post" name="form1" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data" class="auth-profile-form">
        <?= $arResult["BX_SESSION_CHECK"] ?>
        <input type="hidden" name="lang" value="<?= LANG ?>"/>
        <input type="hidden" name="ID" value="<?= $arResult["ID"] ?>"/>

        <div class="profile-block <?= !str_contains($arResult["opened"], "reg") ? "hidden" : "shown" ?>" id="user_div_reg">
            <div class="form-group">
                <label for="NAME"><?= GetMessage('NAME') ?></label>
                <input type="text" id="NAME" name="NAME" maxlength="50" value="<?= $arResult["arUser"]["NAME"] ?>"/>
            </div>
            <div class="form-group">
                <label for="LAST_NAME"><?= GetMessage('LAST_NAME') ?></label>
                <input type="text" id="LAST_NAME" name="LAST_NAME" maxlength="50" value="<?= $arResult["arUser"]["LAST_NAME"] ?>"/>
            </div>
            <div class="form-group">
                <label for="SECOND_NAME"><?= GetMessage('SECOND_NAME') ?></label>
                <input type="text" id="SECOND_NAME" name="SECOND_NAME" maxlength="50" value="<?= $arResult["arUser"]["SECOND_NAME"] ?>"/>
            </div>
            <div class="form-group">
                <label for="LOGIN"><?= GetMessage('LOGIN') ?><span class="star-required">*</span></label>
                <input type="text" id="LOGIN" name="LOGIN" maxlength="50" value="<?= $arResult["arUser"]["LOGIN"] ?>"/>
            </div>
            <div class="form-group">
                <label for="EMAIL"><?= GetMessage('EMAIL') ?><? if ($arResult["EMAIL_REQUIRED"]): ?><span class="star-required">*</span><? endif ?></label>
                <input type="text" id="EMAIL" name="EMAIL" maxlength="50" value="<?= $arResult["arUser"]["EMAIL"] ?>"/>
            </div>

            <div class="form-group">
                <label for="UF_TELEGRAM_ID"><?= GetMessage('UF_TELEGRAM_ID') ?><span class="star-required">*</span></label>
                <input type="text" id="UF_TELEGRAM_ID" name="UF_TELEGRAM_ID" maxlength="50" value="<?= $arResult["arUser"]["UF_TELEGRAM_ID"] ?>"/>
            </div>
        </div>

        <div class="form-actions">
            <input type="submit"
                   name="save"
                   value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">

            <input type="reset"
                   value="<?= GetMessage('MAIN_RESET'); ?>">

        </div>
    </form>

</div>