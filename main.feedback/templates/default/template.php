<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>

<script src="./jquery-3.5.1.min.js"></script>
<script src="./jquery.maskedinput.min.js"></script>
	<form action="<?=POST_FORM_ACTION_URI?>" method="GET" class="form">
	<?=bitrix_sessid_post()?>
        <div class="form-wrapper">
            <input type="text" name="user_name" placeholder="Иван" id="" class="form__input" value="<?=$arResult["AUTHOR_NAME"]?>" required>
            <input type="text" name="user_phone" id="tel" placeholder="+7 (___) ___-__-__" class="form__input" value="<?=$arResult["AUTHOR_PHONE"]?>" required>
            <div class="form-wrapper offset-top_sm display-mobile">
                <div class="agree">
                    <input type="checkbox" name="agree" id="" class="form__checkbox" >
                    <label for="agree" class="form__agree-label">Я согласен с пользовательсиким соглашением</label>
                </div>
            </div>
			<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>" class="form__button">
			<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        </div>
        <div class="form-wrapper offset-top_sm display-laptop">
            <input type="checkbox" name="agree" id="" class="form__checkbox" required>
            <label for="agree" class="form__agree-label">Я согласен с пользовательсиким соглашением</label>
		</div>
		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
		<div class="mf-captcha">
			<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
			<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
			<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
			<input type="text" name="captcha_word" size="30" maxlength="50" value="">
		</div>
		<?endif;?>
	</form>
<div class="nice" style="text-align: center; display: none">
	<h3>Ваше сообщение успешно отправлено!</h3>
</div>

<?
parse_str(html_entity_decode(POST_FORM_ACTION_URI), $postArr);
?>
<div class="postInfo" style="display: none">
	<p id="nameInfo"></p>
	<p id="phoneInfo"></p>
	<p id="dateInfo"></p>
</div>


<script>
        $(document).ready(function() {
            $('#tel').mask("+7 (999) 999-99-99");
		});

		$('.form').submit(function(event) {
			event.preventDefault();
			$.ajax({
				type: "GET",
				url: "<?=POST_FORM_ACTION_URI?>",
				data: $(this).serialize(),
				success: function(response) {
					paramObj = {};
					decodeURI(this.url.split('/?')[1]).replace(/&amp;/g, '&').split("&").forEach(element => {
						paramObj[element.split("=")[0]] = element.split("=")[1]
					});

					document.querySelector("#nameInfo").innerHTML = "Имя: " + paramObj.user_name;
					document.querySelector("#phoneInfo").innerHTML = "Номер: " + paramObj.user_phone.replace("%2B", "+");
					let today = new Date();
					let dd = String(today.getDate()).padStart(2, '0');
					let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
					let yyyy = today.getFullYear();

					today = mm + '/' + dd + '/' + yyyy;
					document.querySelector("#dateInfo").innerHTML = "Дата: " + today;

					document.querySelector(".form").style = "display: none";
					document.querySelector(".nice").style = "display: ; text-align: center";
					

				}  
			});
		});
</script>

