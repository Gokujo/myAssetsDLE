////////////////////////////////////////////////////////////
// =======================================================
// Модуль: MaHarder Assets
// Файл: app.js
// Путь: /engine/skins/maharder/js/app.js
// =======================================================
// Автор: Maxim Harder (c) 2019
// Сайт: https://maxim-harder.de / https://devcraft.club
// Телеграм: http://t.me/MaHarder
// =======================================================
// Ничего не менять
// =======================================================
////////////////////////////////////////////////////////////
var iw = 0;
$(() => {
	var stickys = $(document).find('.sticky');
	setTabs('#box-navi');
	$('.ui.checkbox').checkbox();
	$('.dropdown').dropdown();
	$('.no.label.ui.dropdown').dropdown({
		useLabels: false
	});
	if (stickys > 0) {
		$('.sticky').sticky({
			context: '.docContent',
			pushing: true
		});
	}
	setTabs('.docMenu');
	$('.chosen').tokenfield();
	autosize(document.querySelectorAll('textarea'));
	$(document).on('click', '#box-navi.dropdown .item', function () {
		$.tab('change tab', $(this).data('tab'));
	});

	$(window).resize(function() {
		setTabs('#box-navi');
	});

	$(document).find('.copy_text').each((id, text) => {
		var copyText = text;
		$(copyText).on('click', () => {
			copyText.select();
			copyText.setSelectionRange(0, 99999);
			document.execCommand("copy");
			let helper = $(copyText).parent().find('.copy_help').first();
			$(helper).show(500);
			setTimeout(() => {
				$(helper).hide(250);
			}, 2500);
		});
	})

});

function startLoading() {
	$('.ui.dimmer').addClass('active');
}
function hideLoading() {
	$('.ui.dimmer').removeClass('active');
}

function setTabs(tab) {
	var thisWidth = $(tab).outerWidth(), nav = $(tab);

	function createDropDown(elements, selector){
		var select = "", temp = "", html = "";
		if (selector[0] == "#") select = "id";
		else if (selector[0] == ".") select = "class";
		if (select == "id")
			html += "<div class=\"ui floating dropdown labeled icon button attached\" id='" + selector.replace("#", "") + "'>";
		else if (select == "class")
			html += "<div class=\"ui floating dropdown labeled icon button attached " + selector.replace(".", "") + "\">";

		$(elements).find('.item').each(function () {
			if ($(this).hasClass('active')) {
				html += "<span class=\"text\">" + $(this).html() + "</span><div class=\"menu\">";
			}
			temp += "<div class=\"item";
			if ($(this).hasClass('active')) {
				temp += " active selected";
			}
			temp += "\" data-tab='" + $(this).data('tab') + "'>" + $(this).html() + "</div>";
		});
		html += temp;
		html += "</div></div>";

		return html;
	}

	function createMenu(elements, selector){

		var select = "", temp = "", html = "";
		if (selector[0] == "#") select = "id";
		else if (selector[0] == ".") select = "class";
		if (select == "id")
			html += "<div class=\"ui top attached tabular menu\" id='" + selector.replace("#", "") + "'>";
		else if (select == "class")
			html += "<div class=\"ui top attached tabular menu " + selector.replace(".", "") + "\">";

		$(elements).find('.item').each(function () {
			temp += "<a href='#' class=\"item";
			if ($(this).hasClass('active')) {
				temp += " active";
			}
			temp += "\" data-tab='" + $(this).data('tab') + "'>" + $(this).html() + "</a>";
		});
		html += temp;
		html += "</div>";

		return html;
	}

	function resizeW(tabs, items, elements, selector) {
		let parent = $(selector).parent();
		if(items >= tabs) {
			$(selector).remove();
			$(parent).prepend(createDropDown(elements, selector));
			$(".dropdown").dropdown();
		} else {
			$(selector).remove();
			$(parent).prepend(createMenu(elements, selector));
			$(selector + ' .item').tab();
		}
	}

	function changeWidths(selector) {
		if (iw == 0) {
			$(selector).find('.item').each(function () {
				let temp = $(this).outerWidth();
				iw = Math.abs(iw + temp);
			});
		}
		thisWidth = $(selector).outerWidth();
	}

	$(document).find(tab).each(function () {
		$(tab + ' .item').tab();

		changeWidths(tab);
		$(window).resize(function () {
			changeWidths(tab);
		});

		resizeW(thisWidth, iw, nav, tab);

	});
}
