<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?

if (!empty($arResult['ERROR_MESSAGE'])) {
    ShowMessage($arResult['ERROR_MESSAGE']);
}
?>

<div class="flex-fly-container">
    <div class="title">
        <div class="title-col">
            <h1><? $APPLICATION->ShowTitle(false); ?></h1>
        </div>
        <div class="title-col">
            <?
            if (!empty($arParams["~AUTH_RESULT"])) {
                ShowMessage($arParams["~AUTH_RESULT"]);
            }
            ?>
        </div>
    </div>

    <div class="auth-component-wrapper">

        <form class="auth-component-form" name="form_auth" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">

            <input type="hidden" name="AUTH_FORM" value="Y"/>

            <input type="hidden" name="TYPE" value="AUTH"/>

            <? if ($arResult["BACKURL"] <> ''): ?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <? endif ?>

            <? foreach ($arResult["POST"] as $key => $value): ?>
                <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
            <? endforeach ?>


            <div class="auth-component-flex">

                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col-label">
                        <label for=""><?= GetMessage("AUTH_LOGIN") ?></label>
                    </div>
                    <div class="auth-component-flex-col">
                        <input class="bx-auth-input form-control" type="text" name="USER_LOGIN" maxlength="255"
                               value="<?= $arResult["LAST_LOGIN"] ?>"/>
                    </div>
                </div>

                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col-label">
                        <label for=""><?= GetMessage("AUTH_PASSWORD") ?></label>
                    </div>
                    <div class="auth-component-flex-col">
                        <input class="bx-auth-input form-control" type="password" name="USER_PASSWORD" maxlength="255"
                               autocomplete="off"/>
                        <? if ($arResult["SECURE_AUTH"]): ?>
                            <span class="bx-auth-secure" id="bx_auth_secure"
                                  title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
                            <noscript>
				<span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
                            </noscript>
                            <script type="text/javascript">
                                document.getElementById('bx_auth_secure').style.display = 'inline-block';
                            </script>
                        <? endif ?>
                    </div>
                </div>

                <? if ($arResult["STORE_PASSWORD"] == "Y"): ?>
                    <div class="auth-component-flex-row">
                        <div class="auth-component-flex-col">
                            <input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y"/><label
                                    for="USER_REMEMBER">&nbsp;<?= GetMessage("AUTH_REMEMBER_ME") ?></label>
                        </div>
                    </div>
                <? endif ?>

                <div class="auth-component-flex-row auth-component-flex-row-submit">
                    <div class="auth-component-flex-col">
                        <input type="submit" class="btn btn-primary" name="Login"
                               value="<?= GetMessage("AUTH_AUTHORIZE") ?>"/>
                    </div>
                </div>
            </div>

        </form>
    </div>

</div>

<script type="text/javascript">
    <?if ($arResult["LAST_LOGIN"] <> ''):?>
    try {
        document.form_auth.USER_PASSWORD.focus();
    } catch (e) {
    }
    <?else:?>
    try {
        document.form_auth.USER_LOGIN.focus();
    } catch (e) {
    }
    <?endif?>
</script>


