define(['jquery', 'tmpl!link.modal,link.replace', 'uikit', 'link'], function($, tmpl, uikit, Link) {

    var modal  = $(tmpl.get('link.modal')).appendTo('body'),
        picker = new uikit.modal.Modal(modal),
        title  = modal.find('.js-title'),
        link, handler;

    modal.on('click', '.js-update', function() {
        handler();
    });

    return function(htmleditor, options, editors) {

        editors = editors || [];

        htmleditor.addPlugin('htmlurls', /<a(.+?)>([^<]*)<\/a>/gim, function(marker) {

            var anchor = $(marker.found[0]), txt = anchor.html() || "", href = anchor.attr('href') || "";

            marker.editor.preview.on('click', '#' + marker.uid, function(e) {

                e.preventDefault();

                handler = function() {
                    picker.hide();

                    anchor.attr("href", link.get());
                    anchor.html(title.val());

                    marker.replace(anchor[0].outerHTML);
                };

                title.val(txt);
                picker.show();
                setTimeout(function() { title.focus(); }, 10);

                link = Link.attach(modal.find('.js-linkpicker'), { value: href })
            });

            return tmpl.render('link.replace', { marker: marker, link: href.trim() ? href : null, txt:  txt.trim() ? txt : null, "class": anchor.attr("class") || ""  }).replace(/(\r\n|\n|\r)/gm, '');
        });


        htmleditor.addPlugin('urls', /(?:\[([^\n\]]*)\])(?:\(([^\n\]]*)\))?/gim, function(marker) {

            if(marker.editor.editor.options.mode != "gfm") {
                return marker.found[0];
            }

            if (marker.found[4] && marker.found[4].indexOf("!"+marker.found[0])!=-1) {
                return marker.found[0];
            }

            marker.editor.preview.on('click', '#' + marker.uid, function(e) {

                e.preventDefault();

                handler = function() {
                    picker.hide();

                    marker.replace('[' + title.val() + '](' + link.get() + ')');
                };

                title.val(marker.found[1]);
                picker.show();
                setTimeout(function() { title.focus(); }, 10);

                link = Link.attach(modal.find('.js-linkpicker'), { value: marker.found[2] })
            });

            return tmpl.render('link.replace', { marker: marker, link: marker.found[2].trim() ? marker.found[2] : null, txt:  marker.found[1].trim() ? marker.found[1] : null }).replace(/(\r\n|\n|\r)/gm, '');
        });

        editors.forEach(function(editor) {
            editor.options.plugins.push('htmlurls');
            editor.options.plugins.push('urls');
        });
    };
});
