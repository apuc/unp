/**
 * переменная для хранения объекта
 * sitesetEnter
 *
 * @var sitesetEnter
 */

var ssEnterVariable = null;

/**
 * вызов sitesetEnter в виде
 * синглтона
 *
 * @return sitesetEnter
 */

function ssEnter()
{
    if (ssEnterVariable == null)
        ssEnterVariable = new sitesetEnter();

    return ssEnterVariable;
}

/**
 * класс по работе со стеком
 * вызова клавиши интер
 *
 */

function sitesetEnter()
{
    /**
     * список вызовов
     *
     * @var object
     */

    this.call = [];

    /**
     * метод регистрирует событие класса
     *
     * @param function rule    - правило поределение
     *                           объекта
     * @param srting  alias    - алиас
     * @param integer priority - приоритет исполнения
     *
     */

    this.reg = function (rule, alias, priority) {
        self.call.push({
            'rule':     rule,
            'alias':    alias,
            'priority': priority,
            'active':   true
        });

        self.call = self.call.sort(function sDecrease(first, second) {
             if (first.priority > second.priority)
                return -1;
             else if (first.priority < second.priority)
                return 1;
             else
                return 0;
        })
    };


    /**
     * метод определяет операцию которую необходимо
     * провесит
     *
     * @return boolean
     *
     * @param object e событие
     * @param string alias
     */

    this.can = function (e, alias) {
        var rule   = null;
        var events = [];

        // листаем все зареганные события
        for (i in self.call) {
            if (!self.call[i]['active'])
                continue;

            rule = self.call[i]['rule'];

            if (rule(e))
                events.push(self.call[i]['alias']);
        }

        if (events.length == 0)
            return false;

        if (events[0] == alias) {
            self.deactive();
            return true;
        }

        return false;
    };

    /**
     * метод активирует события
     */

    this.active = function () {
        for (i in self.call)
            self.call[i]['active'] = true;
    };

    /**
     * метод деактивирует события
     */

    this.deactive = function () {
        for (i in self.call)
            self.call[i]['active'] = false;
    };

    var self = this;
}

$(document).ready(function () {
    // гераем событие на кливиши
    $('body').bind('input keydown', function(e) {
        // если нажат интер
        if (e.keyCode == 13)
            // активируем события
            ssEnter().active();
    });
});
