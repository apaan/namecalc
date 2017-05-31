if (console == undefined) {
	console = {
		log: function() {},
	}
}

var recharonly = /[\u060c-\u061a\u064b-\u0669()﴾﴿\u06f0-\u06f9ّ]/g;
var ref = 'ابجدهوزحطيكلمنسعفصقرشتثخذضظغ';
var mapping = {
    'ؤ': 'ا',
    'ئ': 'ا',
    'إ': 'ا',
    'أ': 'ا',
    'آ': 'ا',
    'ى': 'ي',
    'ء': 'ا',
    'ة': 'ه'
};

var AN = [
'الله',
'الرحمن',
'الرحيم',
'الملك',
'القدوس',
'السلام',
'المؤمن',
'المهيمن',
'العزيز',
'الجبار',
'المتكبر',
'الخالق',
'البارئ',
'المصور',
'الغفار',
'القهار',
'الوهاب',
'الرزاق',
'الفتاح',
'العليم',
'القابض',
'الباسط',
'الخافض',
'الرافع',
'المعز',
'المذل',
'السميع',
'البصير',
'الحكم',
'العدل',
'اللطيف',
'الخبير',
'الحليم',
'العظيم',
'الغفور',
'الشكور',
'العلي',
'الكبير',
'الحفيظ',
'المقيت',
'الحسيب',
'الجليل',
'الكريم',
'الرقيب',
'المجيب',
'الواسع',
'الحكيم',
'الودود',
'المجيد',
'الباعث',
'الشهيد',
'الحق',
'الوكيل',
'القوى',
'المتين',
'الولي',
'الحميد',
'المحصى',
'المبدئ',
'المعيد',
'المحيي',
'المميت',
'الحي',
'القيوم',
'الواجد',
'الماجد',
'الواحد',
'الصمد',
'القادر',
'المقتدر',
'المقدم',
'المؤخر',
'الأول',
'الآخر',
'الظاهر',
'الباطن',
'الوالي',
'المتعال',
'البر',
'التواب',
'المنتقم',
'العفو',
'الرؤوف',
'مالك الملك',
'ذو الجلال و الإكرام',
'المقسط',
'الجامع',
'الغني',
'المغني',
'المانع',
'الضار',
'النافع',
'النور',
'الهادي',
'البديع',
'الباقي',
'الوارث',
'الرشيد',
'الصبور'
]


function val1(c) {
	var i = ref.indexOf(c in mapping ? mapping[c] : c);
	if (i==-1) {
		if (c != ' ') {
			console.log('not found: ' + c);
		}
		return 0
	} else {
		//console.log(c + ': ' + ((i % 9)+1) * (Math.pow(10, Math.floor(i/9))));
		return ((i % 9)+1) * (Math.pow(10, Math.floor(i/9)));
	}
}

function val(s) {
	var r = 0;
	for (var i=0; i<s.length; i++) {
		r += val1(s[i]);
	}
	return r;
}

function valDetail(s) {
	var r = {value: 0, components: []};
	for (var i=0; i<s.length; i++) {
		var charval = val1(s[i]);
		r.value += charval;
		if (charval != 0)
			r.components.push({char: s[i], value: charval});
	}
	return r;
}

var AN_values = [{'name': AN[0], 'value': val(AN[0])}];
for (var i=1; i<AN.length; i++) {
	if (AN[i].match(/ال/)) {
		AN_values.push({
			name: AN[i].substring(2),
			value: val(AN[i].substring(2))
		});
	} else {
		AN_values.push({
			name: AN[i],
			value: val(AN[i])
		});
	}
}
AN_values.sort(function(a, b) { return a.value - b.value; });

function findAN(s) {
	var v = val(s);
	return AN_values.filter(function(i) {
			return Math.abs(v-i.value) < 5;
		});
}

if (typeof String.prototype.endsWith !== 'function') {
    String.prototype.endsWith = function(suffix) {
        return this.indexOf(suffix, this.length - suffix.length) !== -1;
    };
}

var AN_jk = AN.filter(function() { return true; });	// copy
var AN_values_jk = AN_values.filter(function() { return true; });
// on load, get jausyan kabier
$(function() {
	$.get('jausyankabir.txt', function(data) {
		var s = data.split(/ يَا|\nيَا|\n/);
		$.each(s, function(i, v) {
			var cleared = v.replace(recharonly, '').trim();
			if ($.inArray(cleared, AN_jk) == -1) {
				// handle untuk Allahumma inni as'aluka bismika
				if (cleared.indexOf('اللهم') == 0 && cleared.endsWith('اسمك')) {
					if (val(cleared) == 402)
						return;
				} 
				AN_jk.push(cleared.match(/^ال/) && i != 0 ? cleared.substring(2) : cleared);
				AN_values_jk.push({name: cleared, value: val(cleared)});
			}
		});
	});
});

function findAN_jk(s) {
	var v = val(s);
	return AN_values_jk.filter(function(i) {
			return Math.abs(v-i.value) < 5;
		});
}
