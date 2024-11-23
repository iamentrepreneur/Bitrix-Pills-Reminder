<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?

if (!empty($arParams["~AUTH_RESULT"])) {
    ShowMessage($arParams["~AUTH_RESULT"]);
}

?>

<div class="title">
    <div class="title-col">
        <h1><? $APPLICATION->ShowTitle(false); ?></h1>
    </div>
    <div class="title-col">

    </div>
</div>

<div class="auth-component-wrapper">

    <form class="auth-component-form" name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
        <?
        if ($arResult["BACKURL"] <> '') {
            ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <?
        }
        ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="SEND_PWD">

        <div class="auth-component-flex">

            <div class="auth-component-flex-row">
                <div class="auth-component-flex-col-label">
                    <label for=""><?= GetMessage("sys_forgot_pass_login1") ?></label>
                </div>
                <div class="auth-component-flex-col">
                    <input type="text" name="USER_LOGIN" value="<?= $arResult["USER_LOGIN"] ?>"/>
                    <input type="hidden" name="USER_EMAIL"/>
                </div>
            </div>

            <div class="auth-component-flex-row">
                <div class="auth-component-flex-col-label">
                    <label for=""><? echo GetMessage("sys_forgot_pass_note_email") ?></label>
                </div>
            </div>

            <div class="auth-component-flex-row">
                <div class="auth-component-flex-col">
                    <input class="btn btn-primary" type="submit" name="send_account_info" value="<?= GetMessage("AUTH_SEND") ?>"/>
                </div>
            </div>
        </div>

        <div class="auth-component-footer">
            <div class="auth-component-footer-col">
                <a href="<?= $arResult["AUTH_AUTH_URL"] ?>"><?= GetMessage("AUTH_AUTH") ?></a>
            </div>
        </div>
    </form>

</div>

<script type="text/javascript">
    document.bform.onsubmit = function () {
        document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
    };
    document.bform.USER_LOGIN.focus();
</script>
