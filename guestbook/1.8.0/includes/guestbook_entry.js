// guestbook.js

function emoticon(text) {
			var txtarea = document.post.yourmessage;
			text = ' ' + text + ' ';
			if (txtarea.createTextRange && txtarea.caretPos) {
				var caretPos = txtarea.caretPos;
				caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
				txtarea.focus();
			} else {
				txtarea.value  += text;
				txtarea.focus();
			}
		}

		/**
		 * @author Mark Skilbeck (mahcuz.com), DigiOz Guestbook (digioz.com)
		 *
		 * 'element_id' :
		 * 		{'event' : 'event-type' (sans 'on'), 'char' : 'char to be inserted', 'opened' : false}
		 */
		var observers_obj = {
			// Element ID	: listener
			'bold' 			: {'event' : 'click', 'char' : 'b', 'opened' : false},
			'italic' 		: {'event' : 'click', 'char' : 'i', 'opened' : false},
			'underline' 	: {'event' : 'click', 'char' : 'u', 'opened' : false},
			'center'		: {'event' : 'click', 'char' : 'center', 'opened' : false}
		}

		/**
		 * Onload listener.
		 */
		window.onload = function () {

			// Add the observers (think observer pattern).
			addObservers(observers_obj);
		}

		function addObservers(observers) {

			/**
			 * loop through observers object, adding the appropriate listeners
			 */
			for(i in observers) {

				if(typeof document.getElementById(i) != 'undefined') {

					// firefox, chrome, opera.
					if(document.getElementById(i).addEventListener)	{
						document.getElementById(i).addEventListener(observers[i]['event'], BBCode, false);
					}
					// IE
					else if (document.getElementById(i).attachEvent) {
						var event = 'on' + observers[i]['event'];
						document.getElementById(i).attachEvent(event, BBCode);
					}
					// others
					else {
					}

				}
			}
		}

		/**
		 * Determines what needs to be inserted (opened or closed),
		 * then calls placeAtCaret() with the value to insert as an argument.
		 */
		function BBCode(e) {
			// *All* (read: most) browsers support the window.event object.
			// We use this because IE will not point _this_ to the event target.
			if (!e) var e = window.event;

			// Firefox, chrome, opera
			if (e.target) {
				var t = e.target;
			}
			// IE
		 	else {
		 		var t = e.srcElement;
		 	}

		 	// Determine whether the code is opened or closed.
		 	if (!observers_obj[t.id]['opened']) {
		 		// Unopend.
		 		placeAtCaret('[' + observers_obj[t.id]['char'] + ']');
		 		observers_obj[t.id]['opened'] = true;
		 	}
		 	else {
		 		// Opened. Close it.
		 		placeAtCaret('[/' + observers_obj[t.id]['char'] +']');
		 		observers_obj[t.id]['opened'] = false;
		 	}
		}

		/**
		 * Places given text at current cursor position.
		 */
		function placeAtCaret(val) {
			var text_area = document.getElementById('yourmessage');

			// Mozilla, opera.
			if (typeof text_area.selectionStart !== 'undefined') {
				var pre = text_area.value.substring(0, text_area.selectionStart);
				var post = text_area.value.substring(text_area.selectionStart, text_area.value.length);
				var text = pre + val + post;
				text_area.value = text;
				text_area.focus();
				text_area.setSelectionRange(text_area.value.length, text_area.value.length);
			}
			else {
				// IE
				if(typeof text_area.createTextRange !== 'undefined') {
					text_range = text_area.createTextRange();
					text = text_range.text + val;
					text_area.value = text;
					text_area.focus();
				}
			}
		}
