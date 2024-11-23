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
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arResult["SHOW_SMS_FIELD"] == true) {
    CJSCore::Init('phone_auth');
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
    <?
    if (!empty($arParams["~AUTH_RESULT"])) {
        ShowMessage($arParams["~AUTH_RESULT"]);
    }
    ?>
    <? if ($arResult["SHOW_EMAIL_SENT_CONFIRMATION"]): ?>
        <p><? echo GetMessage("AUTH_EMAIL_SENT") ?></p>
    <? endif; ?>

    <? if (!$arResult["SHOW_EMAIL_SENT_CONFIRMATION"] && $arResult["USE_EMAIL_CONFIRMATION"] === "Y"): ?>
        <p><? echo GetMessage("AUTH_EMAIL_WILL_BE_SENT") ?></p>
    <? endif ?>
    <noindex>
        <form class="auth-component-form" method="post" action="<?= $arResult["AUTH_URL"] ?>" name="bform"
              enctype="multipart/form-data">

            <input type="hidden" name="AUTH_FORM" value="Y"/>
            <input type="hidden" name="TYPE" value="REGISTRATION"/>


            <div class="auth-component-flex">

                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col-label">
                        <label for=""><?= GetMessage("AUTH_NAME") ?></label>
                    </div>
                    <div class="auth-component-flex-col">
                        <input type="text" name="USER_NAME" maxlength="50" value="<?= $arResult["USER_NAME"] ?>"
                               class="bx-auth-input"/>
                    </div>
                </div>

                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col-label">
                        <label for=""><?= GetMessage("AUTH_LAST_NAME") ?></label>
                    </div>
                    <div class="auth-component-flex-col">
                        <input type="text" name="USER_LAST_NAME" maxlength="50"
                               value="<?= $arResult["USER_LAST_NAME"] ?>" class="bx-auth-input"/>
                    </div>
                </div>

                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col-label">
                        <label for=""><span class="starrequired">*</span><?= GetMessage("AUTH_LOGIN_MIN") ?></label>
                    </div>
                    <div class="auth-component-flex-col">
                        <input type="text" name="USER_LOGIN" maxlength="50" value="<?= $arResult["USER_LOGIN"] ?>"
                               class="bx-auth-input"/>
                    </div>
                </div>

                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col-label">
                        <label for=""><span class="starrequired">*</span><?= GetMessage("AUTH_PASSWORD_REQ") ?></label>
                    </div>
                    <div class="auth-component-flex-col">
                        <input type="password" name="USER_PASSWORD" maxlength="255"
                               value="<?= $arResult["USER_PASSWORD"] ?>" class="bx-auth-input" autocomplete="off"/>
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


                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col-label">
                        <label for=""><span class="starrequired">*</span><?= GetMessage("AUTH_CONFIRM") ?></label>
                    </div>
                    <div class="auth-component-flex-col">
                        <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="255"
                               value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>" class="bx-auth-input"
                               autocomplete="off"/>
                    </div>
                </div>

                <? if ($arResult["EMAIL_REGISTRATION"]): ?>
                <div class="auth-component-flex-row">
                    <div class="auth-component-flex-col-label">
                        <label for=""><? if ($arResult["EMAIL_REQUIRED"]): ?><span
                                    class="starrequired">*</span><? endif ?><?= GetMessage("AUTH_EMAIL") ?></label>
                    </div>
                    <div class="auth-component-flex-col">
                        <input type="text" name="USER_EMAIL" maxlength="255"
                               value="<?= $arResult["USER_EMAIL"] ?>" class="bx-auth-input"/>
                    </div>
                </div>
                <? endif ?>

                <div class="auth-component-flex-row auth-component-flex-row-submit">
                    <div class="auth-component-flex-col">
                        <input class="btn btn-primary" type="submit" name="Register" value="<?= GetMessage("AUTH_REGISTER") ?>"/>
                    </div>
                </div>
            </div>

            <div class="auth-component-footer">
                <div class="auth-component-footer-col">
                    <a href="<?= $arResult["AUTH_AUTH_URL"] ?>" rel="nofollow"><?= GetMessage("AUTH_AUTH") ?></a>
                </div>
            </div>

        </form>

        <script type="text/javascript">
            document.bform.USER_NAME.focus();
        </script>

    </noindex>
</div>