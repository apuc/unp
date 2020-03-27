
/**
 *
 *
 */

$(document).ready(function () {

    var bans = [
        "header"
    ];

    /**
     * метод позволяет получить хэш
     *
     * @return string|false
     */

    var getHash = function () {
        var hash = window.location.hash;

        if (hash.length == 0)
            return false;

        return hash.replace(/[#]+/g, '');
    };

    // если есть хэш
    if (getHash() != false)
        // имитируем клик
        $("a[href='#" + getHash() + "']").trigger('click');

    /**
     * триггер на перещелк таба
     */

    $("a[data-toggle='tab']").each(function () {
        for (var i in bans)
            if ($(this).parents(bans[i]).length > 0)
                return;

        $(this).on('shown.bs.tab', function (e) {
            // подставляем хэш в урл
            location.hash = $(e.target).attr('href').replace(/[#]+/g, '');
        });
    });
});
