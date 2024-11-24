<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?
if (!empty($arResult['ERROR_MESSAGE'])):?>
    <? ShowMessage($arResult['ERROR_MESSAGE']); ?>
<? endif; ?>


<div class="bx-auth-profile">

    <form class="auth-profile-form" name="form_auth" method="post" target="_top"
          action="<?= $arResult["AUTH_URL"] ?>">

        <input type="hidden" name="AUTH_FORM" value="Y"/>

        <input type="hidden" name="TYPE" value="AUTH"/>

        <? if ($arResult["BACKURL"] <> ''): ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
        <? endif ?>

        <? foreach ($arResult["POST"] as $key => $value): ?>
            <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
        <? endforeach ?>


        <div class="profile-block">
            <div class="form-group">
                <label for=""><?= GetMessage("AUTH_LOGIN") ?></label>
                <input type="text" name="USER_LOGIN" maxlength="255"
                       value="<?= $arResult["LAST_LOGIN"] ?>"/>
            </div>

            <div class="form-group">
                <label for=""><?= GetMessage("AUTH_PASSWORD") ?></label>
                <input type="password" name="USER_PASSWORD" maxlength="255"
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

            <? if ($arResult["STORE_PASSWORD"] == "Y"): ?>
                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col">
                        <input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y"/><label
                                for="USER_REMEMBER">&nbsp;<?= GetMessage("AUTH_REMEMBER_ME") ?></label>
                    </div>
                </div>
            <? endif ?>
        </div>

        <div class="form-actions">
            <input type="submit" class="btn btn-primary" name="Login"
                   value="<?= GetMessage("AUTH_AUTHORIZE") ?>"/>
        </div>

    </form>
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


