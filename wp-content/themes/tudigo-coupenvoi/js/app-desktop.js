
Element.prototype.addClass = function (className) {
    if (this.classList)
        this.classList.add(className);
    else
        this.className += ' ' + className;
    return this;
};
/**
 * Remove class from an Element
 * @author: Nicolas Nowak
 * @date: 2016-09-23
 * @param className
 */
Element.prototype.removeClass = function (className) {
    if (this.classList)
        this.classList.remove(className);
    else
        this.className = this.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    return this;
};
/**
 * Toggle class from an Element
 * @author: Nicolas Nowak
 * @date: 2016-09-23
 * @param className
 */
Element.prototype.toggleClass = function (className) {
    if (this.classList) {
        this.classList.toggle(className);
    }
    else {
        var classes = this.className.split(' ');
        var existingIndex = -1;
        for (var i = classes.length; i--;) {
            if (classes[i] === className)
                existingIndex = i;
        }
        if (existingIndex >= 0)
            classes.splice(existingIndex, 1);
        else
            classes.push(className);
        this.className = classes.join(' ');
    }
    return this;
};
/**
 * Find first children
 * @author: Nicolas Nowak
 * @date: 2016-09-23
 * @param selector
 */
Element.prototype.find = function (selector) {
    return this.querySelector(selector);
};
/**
 * Find all childrens
 * @author: Nicolas Nowak
 * @date: 2016-09-23
 * @param selector
 */
Element.prototype.findAll = function (selector) {
    var elts = this.querySelectorAll(selector);
    var results = [];
    for (var i = 0; i < elts.length; i++)
        results.push(elts[i]);
    return results;
};
/**
 * Find first parent
 * @author: Tiffanie Bouillot
 * @date: 2016-09-27
 */
Element.prototype.parent = function () {
    return this.parentElement;
};
/**
 * Change / Select attr element
 * @author: Tiffanie Bouillot
 * @date: 2016-09-27
 * @param selector
 * @param optional value
 */
Element.prototype.attr = function (selector, value) {
    if (typeof value !== 'undefined') {
        this.setAttribute(selector, value);
    }
    else {
        return this.getAttribute(selector);
    }
};
/**
 * Detect class of element
 * @author: Tiffanie Bouillot
 * @date: 2016-09-28
 * @param selector
 */
Element.prototype.hasClass = function (className) {
    if (this.classList.contains(className)) {
        return true;
    }
    else {
        return false;
    }
};
/**
 * Detect class
 * @author: Tiffanie Bouillot
 * @date: 2016-09-28
 * @param content
 */
Element.prototype.html = function (content) {
    this.innerHTML = content;
    return this;
};
/**
 * Delegate
 * @author: Nowak Nicolas
 * @date: 2016-09-28
 * @param content
 */
Element.prototype.delegate = function (ev, el, callback) {
    el = el.replace(/\./g, "");
    var allowedEvents = ['click', 'touchend'];
    if (allowedEvents.indexOf(ev) < 0)
        throw new Error('Delegate doesn\'t support yet this event : ' + ev);
    this.addEventListener(ev, function (e) {
        var elt = e.target;
        var found = false;
        if (elt && ((" " + elt.className + " ").replace(/[\n\t]/g, " ").indexOf(' ' + el + ' ') > -1)) {
            found = true;
        }
        else {
            if (elt) {
                while (found === false) {
                    elt = elt.parentNode;
                    if ((" " + elt.className + " ").replace(/[\n\t]/g, " ").indexOf(' ' + el + ' ') > -1)
                        found = true;
                    if (elt.tagName === 'HTML')
                        return;
                }
                if (elt !== null) {
                    found = true;
                }
            }
        }
        if (found === true)
            callback.call(callback, e, elt);
    }.bind(callback));
};
/**
 * Find first children
 * @author: Nicolas Nowak
 * @date: 2016-09-23
 * @param selector
 */
Element.prototype.val = function () {
    var el = this;
    return el.value;
};
;
/**
 * Request static class, manage AJAX calls
 * @author: Nicolas Nowak
 * @date: 2016-09-29
 * @version: 0.1
 */
var Request = (function () {
    function Request() {
    }
    Request.AJAX = function (opts) {
        // Set callback
        if (opts.success)
            Request.callback = opts.success;
        // Build params
        var data = { 'data': opts.data };
        var params = Request.formatParams(data);
        var request = new XMLHttpRequest();
        request.open('POST', opts.url, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send(params);
        request.onreadystatechange = function (evt) {
            if (request.readyState === 4 && request.status === 200) {
                var xhr = JSON.parse(request.response);
                if (Request.callback)
                    Request.callback.call(Request.callback, xhr);
            }
        };
    };
    /**
     * Recusive HTTP encoded parameters
     * @param params
     * @returns {string}
     */
    Request.formatParams = function (obj, prefix) {
        var str = [];
        for (var p in obj) {
            if (obj.hasOwnProperty(p)) {
                var k = prefix ? prefix + '[' + p + ']' : p, v = obj[p];
                str.push(typeof v === 'object' ? Request.formatParams(v, k) : encodeURIComponent(k) + '=' + encodeURIComponent(v));
            }
        }
        return str.join('&');
    };
    Request.callback = null;
    return Request;
})();
var FormValidator = (function () {
    function FormValidator(opts) {
        this._target = null; // Form Element
        this._inputs = []; // Array of inputs
        this.parent = false;
        this.fviArray = [];
        this._target = opts.target;
        this._inputs = opts.inputs;
        if (opts.hasOwnProperty('parent'))
            this.parent = opts.parent;
        this.initialize();
    }
    /**
     * Initialize inputs.
     * Instanciate Input class
     */
    FormValidator.prototype.initialize = function () {
        for (var i = 0; i < this._inputs.length; i++) {
            var input = this._inputs[i];
            this.fviArray.push(new FormValidatorInput({ 'input': input, 'parent': this.parent }));
        }
    };
    /**
     * Check if the form is valid
     * @returns {boolean}
     */
    FormValidator.prototype.isValid = function () {
        this.check();
        for (var i = 0; i < this.fviArray.length; i++)
            if (this.fviArray[i].isValid() === false)
                return false;
        return true;
    };
    /**
     * Check all form
     */
    FormValidator.prototype.check = function () {
        for (var i = 0; i < this.fviArray.length; i++)
            this.fviArray[i].process();
    };
    /**
     * Generate and return form data
     * @returns {any}: form data
     */
    FormValidator.prototype.getData = function () {
        var data = {};
        for (var i = 0; i < this.fviArray.length; i++) {
            var input = this.fviArray[i];
            data[input.getName()] = input.getValue();
        }
        return data;
    };
    return FormValidator;
})();
var FormValidatorInput = (function () {
    function FormValidatorInput(opts) {
        this._input = null;
        this._type = null;
        this._name = null;
        this._value = null;
        this._valid = false;
        this.parent = false;
        this.elementToToggle = null;
        this.allowedTypes = ['text', 'email', 'tel', 'zipcode', 'number', 'birthdate'];
        this._input = opts.input;
        this.parent = opts.parent;
        this.check();
        this.defineValidationParent();
        this._type = this._input.getAttribute('data-type');
        this._name = this._input.getAttribute('name');
        this.initializeEvents();
    }
    /**
     * Define element where toggle success & error class
     */
    FormValidatorInput.prototype.defineValidationParent = function () {
        if (this.parent === false)
            this.elementToToggle = this._input;
        else
            this.elementToToggle = this._input.parentNode;
    };
    /**
     * Check all needed input pre-requisities
     */
    FormValidatorInput.prototype.check = function () {
        if (this._input.tagName !== 'INPUT')
            throw new Error('Element must be an INPUT');
        if (this.allowedTypes.indexOf(this._input.getAttribute('data-type')) < 0)
            throw new Error('Unknown input type \'' + this._input.getAttribute('data-type') + '\'. This class can\'t validate this type.');
        if (this._input.getAttribute('name') === null)
            throw new Error('Please specify attrbute \'name\' in your input Element.');
    };
    /**
     * Initialize Input Events
     */
    FormValidatorInput.prototype.initializeEvents = function () {
        this._input.addEventListener('blur', this.process.bind(this));
    };
    /**
     * Process input validation
     */
    FormValidatorInput.prototype.process = function () {
        this._valid = false;
        this._value = this._input.val();
        // TEXT CASE
        if (this._type === 'text') {
            if (this._value.length >= 2)
                this._valid = true;
        }
        // EMAIL CASE
        if (this._type === 'email') {
            var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            if (re.test(this._value))
                this._valid = true;
        }
        // NUMBER CASE
        if (this._type === 'number') {
            var re = /^[0-9]{1}[0-9 ]*$/;
            if (re.test(this._value))
                this._valid = true;
        }
        // BIRTHDATE CASE
        if (this._type === 'birthdate') {
            var re = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
            if (re.test(this._value))
                this._valid = true;
        }
        // ZIPCODE CASE
        if (this._type === 'zipcode') {
            var re = /^\d{5}(?:[-\s]\d{4})?$/;
            if (re.test(this._value))
                this._valid = true;
        }
        // TEL Case
        if (this._type === 'tel') {
            // Remove whitespaces and dots
            this._value = this._value.replace(/ /g, '').replace(/\./g, '');
            this._input.value = this._value;
            var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
            if (re.test(this._value))
                this._valid = true;
        }
        // Manage success/error DOM classes
        if (!this._valid) {
            this.elementToToggle.removeClass('success');
            this.elementToToggle.addClass('error');
        }
        else {
            this.elementToToggle.removeClass('error');
            this.elementToToggle.addClass('success');
        }
    };
    /************** ACCESSORS **************/
    /**
     * Return input value
     * @returns {string}: input value
     */
    FormValidatorInput.prototype.getValue = function () {
        return this._value;
    };
    /**
     * Return input name
     * @returns {string}: input name
     */
    FormValidatorInput.prototype.getName = function () {
        return this._name;
    };
    /**
     * Returns if an input is valid or not
     * @returns {boolean}: valid or not
     */
    FormValidatorInput.prototype.isValid = function () {
        return this._valid;
    };
    return FormValidatorInput;
})();
var GmapsEvent = (function () {
    function GmapsEvent() {
    }
    GmapsEvent.RETRIEVED = '__GmapsEvent_retrieved';
    GmapsEvent.CLEAR = '__GmapsEvent_clear';
    GmapsEvent.NO_RESULT = '__GmapsEvent_no_result';
    return GmapsEvent;
})();
var Container = (function () {
    function Container() {
        this.body = null;
        this.wrapper = null;
        this.Generics = null;
        this.Google = null;
        this.body = document.querySelector('body');
        this.wrapper = this.body.find('.main-wrapper');
        this.initializeDependencies();
    }
    Container.prototype.initializeDependencies = function () {
        this.Generics = new Generics();
        this.Google = new Google();
    };
    return Container;
})();
/**
 * Criteria module for Projects Finder
 * @module: Criteria
 * @classes: Keyword, Category
 */
var Criteria;
(function (Criteria) {
    /**
     * @class: Keyword
     */
    var Keyword = (function () {
        function Keyword(apply) {
            // DOM Elements
            this.dom = {
                container: null,
                input: null,
            };
            this.timeout = null;
            this.delay = 500;
            // Criteria
            this.apply = null;
            this.apply = apply;
            this.dom.container = document.querySelector('.main-wrapper');
            this.dom.input = this.dom.container.find('input[name="keywords"]');
            this.events();
        }
        /**
         * Initialize events
         */
        Keyword.prototype.events = function () {
            this.dom.input.addEventListener('keyup', this.process.bind(this));
        };
        /**
         * Clear input
         */
        Keyword.prototype.clear = function () {
            this.dom.input.value = '';
        };
        /**
         * Detect user typing | prevent from spamming request
         */
        Keyword.prototype.process = function () {
            if (this.timeout)
                clearTimeout(this.timeout);
            this.timeout = setTimeout(this.request.bind(this), this.delay);
        };
        /**
         * Call apply function to request projects
         */
        Keyword.prototype.request = function () {
            var keyword = this.dom.input.val();
            this.apply(keyword);
        };
        return Keyword;
    })();
    Criteria.Keyword = Keyword;
    /**
     * @class: Category
     */
    var Category = (function () {
        function Category(apply) {
            // DOM Elements
            this.dom = {
                container: null,
                items: null,
            };
            // Criteria
            this.apply = null;
            this.apply = apply;
            this.dom.container = document.querySelector('.main-wrapper');
            this.dom.items = this.dom.container.findAll(".filter-category");
            this.getItems();
            this.events();
        }
        /**
         * Initialize events
         */
        Category.prototype.events = function () {
        };
        Category.prototype.getItems = function () {
            var self = this;
            this.dom.container.delegate('click', '.filter-category', function (e, el) {
                if (el.hasClass('active'))
                    var cat = 'timestamp';
                else
                    var cat = el.getAttribute('data-category');
                self.apply(cat);
                self.toggleActive(el);
            });
        };
        Category.prototype.toggleActive = function (el) {
            for (var i = 0; i < this.dom.items.length; i++) {
                if (this.dom.items[i] != el)
                    this.dom.items[i].removeClass('active');
            }
            el.toggleClass('active');
        };
        Category.prototype.clearCategories = function () {
            for (var i = 0; i < this.dom.items.length; i++) {
                this.dom.items[i].removeClass('active');
            }
        };
        return Category;
    })();
    Criteria.Category = Category;
})(Criteria || (Criteria = {}));
var Generics = (function () {
    function Generics() {
        this._already_open = null;
        this.dom = {
            body: null,
            header: null,
            burger: null,
            menu: {
                container: null,
                mentions: null,
                rules: null,
            },
            connexion: {
                rules: null,
            },
            last_popin: null,
            popins: {
                container: null,
                banned: {
                    container: null,
                    cross: null,
                    closeLink: null,
                },
                connexion: {
                    container: null,
                    inputs: [],
                    cross: null,
                    email: null,
                    facebook: null,
                    cta: null,
                    errorMessage: null
                },
                mentions: {
                    container: null,
                    cross: null
                },
                rules: {
                    container: null,
                    cross: null,
                    cta: null,
                },
                submitted: {
                    container: null,
                    cross: null
                },
                form: {
                    container: null,
                    inputs: [],
                    cross: null,
                    name: null,
                    firstname: null,
                    email: null,
                    birthdate: null,
                    cta: null
                },
                voted: {
                    container: null,
                    cross: null,
                    closeLink: null,
                },
                shared: {
                    container: null,
                    cross: null,
                },
                first_subscribe: {
                    container: null,
                    cross: null,
                },
                need_activate: {
                    container: null,
                    cross: null,
                },
            },
            footer: {
                container: null,
                mentions: null,
                rules: null,
            }
        };
        this.duration = {
            open: 0.2,
            close: 0.3,
        };
        this.getDOM();
        this.initializeEvents();
    }
    /**
     * Retrieve DOM
     */
    Generics.prototype.getDOM = function () {
        this.dom.body = document.querySelector('body');
        this.dom.header = document.querySelector('header');
        if (document.querySelectorAll('.burger').length === 0)
            return;
        this.dom.burger = this.dom.header.find('.burger');
        this.dom.menu.container = this.dom.header.find('.menu-open');
        this.dom.popins.container = document.querySelector('.popins');
        this.dom.footer.container = document.querySelector('footer');
        // Banned
        this.dom.popins.banned.container = this.dom.popins.container.find('.banned');
        this.dom.popins.banned.cross = this.dom.popins.banned.container.find('.cross');
        this.dom.popins.banned.closeLink = this.dom.popins.banned.container.find('.close-link');
        // Mentions
        this.dom.popins.mentions.container = this.dom.popins.container.find('.mentions');
        this.dom.popins.mentions.cross = this.dom.popins.mentions.container.find('.cross');
        this.dom.footer.mentions = this.dom.footer.container.find('.mentions');
        this.dom.menu.mentions = this.dom.menu.container.find('.mentions');
        // Règlement
        this.dom.popins.rules.container = this.dom.popins.container.find('.rules');
        this.dom.popins.rules.cross = this.dom.popins.rules.container.find('.cross');
        this.dom.menu.rules = this.dom.menu.container.find('.rules');
        this.dom.connexion.rules = this.dom.body.find('.popin.connexion .cta-rules');
        this.dom.footer.rules = this.dom.footer.container.find('.rules');
        // Submitted (fin tunnel)
        this.dom.popins.submitted.container = this.dom.popins.container.find('.subscribe-validated');
        this.dom.popins.submitted.cross = this.dom.popins.submitted.container.find('.cross');
        // Voted (end of vote)
        this.dom.popins.voted.container = this.dom.popins.container.find('.vote-validated');
        this.dom.popins.voted.cross = this.dom.popins.voted.container.find('.cross');
        this.dom.popins.voted.closeLink = this.dom.popins.voted.container.find('.close-link');
        // First Subscribe
        this.dom.popins.first_subscribe.container = this.dom.popins.container.find('.subscribe-to-validate');
        this.dom.popins.first_subscribe.cross = this.dom.popins.first_subscribe.container.find('.cross');
        // Need Activate
        this.dom.popins.need_activate.container = this.dom.popins.container.find('.need-activate');
        this.dom.popins.need_activate.cross = this.dom.popins.need_activate.container.find('.cross');
        // Shared (already shared)
        this.dom.popins.shared.container = this.dom.popins.container.find('.already-shared');
        this.dom.popins.shared.cross = this.dom.popins.shared.container.find('.cross');
        // Connexion (subscribe before vote)
        this.dom.popins.connexion.container = this.dom.popins.container.find('.connexion');
        this.dom.popins.connexion.inputs = this.dom.popins.connexion.container.findAll('.input');
        this.dom.popins.connexion.cross = this.dom.popins.connexion.container.find('.cross');
        this.dom.popins.connexion.email = this.dom.popins.connexion.container.find('.js-connexion-email');
        this.dom.popins.connexion.cta = this.dom.popins.connexion.container.find('.js-connexion-cta');
        this.dom.popins.connexion.facebook = this.dom.popins.connexion.container.find('.facebook');
        this.dom.popins.connexion.errorMessage = this.dom.popins.connexion.container.find('.message-error');
        // Form (subscribe before vote)
        this.dom.popins.form.container = this.dom.popins.container.find('.form');
        this.dom.popins.form.inputs = this.dom.popins.form.container.findAll('.input');
        this.dom.popins.form.cross = this.dom.popins.form.container.find('.cross');
        this.dom.popins.form.name = this.dom.popins.form.container.find('.js-form-name');
        this.dom.popins.form.firstname = this.dom.popins.form.container.find('.js-form-firstname');
        this.dom.popins.form.email = this.dom.popins.form.container.find('.js-form-email');
        this.dom.popins.form.birthdate = this.dom.popins.form.container.find('.js-form-birthdate');
        this.dom.popins.form.cta = this.dom.popins.form.container.find('.js-form-cta');
        this._already_open = false;
    };
    /**
     * Initialize generics events
     */
    Generics.prototype.initializeEvents = function () {
        var _this = this;
        // Menu
        this.dom.burger.addEventListener('click', function (e) {
            if (!e.currentTarget.classList.contains('open'))
                Google.pushCustomTracker('Menu', 'Ouverture menu');
            _this.dom.burger.toggleClass('open');
            _this.dom.menu.container.toggleClass('open');
        });
        // Popins - BANNED
        this.dom.popins.banned.cross.addEventListener('click', function () {
            _this.closePopin('banned');
        });
        if (this.dom.popins.banned.closeLink) {
            this.dom.popins.banned.closeLink.addEventListener('click', function () {
                _this.closePopin('banned');
            });
        }
        // Popins - Mentions
        this.dom.menu.mentions.addEventListener('click', function () {
            Google.pushCustomTracker('Menu', 'Mentions légales');
            _this.openPopin('mentions');
        });
        this.dom.footer.mentions.addEventListener('click', function () {
            Google.pushCustomTracker('Footer', 'Mentions légales');
            _this.openPopin('mentions');
        });
        this.dom.popins.mentions.cross.addEventListener('click', function () {
            _this.closePopin('mentions');
        });
        // Popins - Rules
        this.dom.menu.rules.addEventListener('click', function () {
            Google.pushCustomTracker('Menu', 'Règlement');
            _this.openPopin('rules');
        });
        this.dom.connexion.rules.addEventListener('click', function () {
            Google.pushCustomTracker('Connexion', 'Règlement');
            _this.openPopin('rules');
        });
        this.dom.footer.rules.addEventListener('click', function () {
            Google.pushCustomTracker('Footer', 'Règlement');
            _this.openPopin('rules');
        });
        this.dom.popins.rules.cross.addEventListener('click', function () {
            _this.closePopin('rules');
        });
        // Popins - Submitted
        this.dom.popins.submitted.cross.addEventListener('click', function (e) {
            var link = e.currentTarget.getAttribute("data-redirect");
            document.location.href = link;
        });
        // Popins - Voted
        this.dom.popins.voted.cross.addEventListener('click', function () {
            _this.closePopin('voted');
        });
        if (this.dom.popins.voted.closeLink) {
            this.dom.popins.voted.closeLink.addEventListener('click', function () {
                _this.closePopin('voted');
            });
        }
        // Popins - First Subscribe
        this.dom.popins.first_subscribe.cross.addEventListener('click', function () {
            _this.closePopin('first_subscribe');
        });
        // Popins - Need Activate
        this.dom.popins.need_activate.cross.addEventListener('click', function () {
            _this.closePopin('need_activate');
        });
        // Popins - Shared
        this.dom.popins.shared.cross.addEventListener('click', function () {
            _this.closePopin('shared');
        });
        // Popins - Form
        this.dom.popins.form.cross.addEventListener('click', function () {
            _this.closePopin('form');
        });
        // Popins - Connexion
        this.dom.popins.connexion.cross.addEventListener('click', function () {
            _this.closePopin('connexion');
        });
    };
    Generics.prototype.openPopin = function (popin) {
        var el = this.dom.popins[popin].container;
        TweenMax.fromTo(el, this.duration.open, { top: '-60%' }, { top: '50%', ease: Power3.ease, onStart: function () {
                this.dom.popins.container.removeClass('hide');
                el.removeClass('hide');
                el.style.left = '0%';
                if (this.dom.last_popin)
                    this._already_open = true;
                this.dom.last_popin = popin;
            }.bind(this) });
    };
    Generics.prototype.closePopin = function (popin) {
        var el = this.dom.popins[popin].container;
        TweenMax.fromTo(el, this.duration.close, { top: '50%' }, { top: '-60%', ease: Power3.ease, onComplete: function () {
                if (this.dom.last_popin != 'rules' || this._already_open == false)
                    this.dom.popins.container.addClass('hide');
                else
                    this._already_open = false;
                this.dom.last_popin = null;
                el.addClass('hide');
                el.style.left = '0%';
            }.bind(this) });
    };
    return Generics;
})();
var Google = (function () {
    function Google() {
        Google.body = document.body;
        Google.trackers = Google.body.findAll('.tracker');
        Google.events();
    }
    Google.events = function () {
        if (Google.trackers != null) {
            for (var i = 0; i < Google.trackers.length; i++) {
                Google.trackers[i].addEventListener("click", function () {
                    var cat = this.getAttribute('data-ga-category');
                    var action = this.getAttribute('data-ga-action');
                    Google.pushCustomTracker(cat, action);
                });
            }
        }
    };
    Google.pushCustomTracker = function (cat, action) {
        _gaq.push(['_trackEvent', cat, action, 'desktop']);
    };
    return Google;
})();
var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var End;
(function (End) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
        }
        return Core;
    })(Container);
    End.Core = Core;
})(End || (End = {}));
var Error;
(function (Error) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
        }
        return Core;
    })(Container);
    Error.Core = Core;
})(Error || (Error = {}));
var ProjectsList;
(function (ProjectsList) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
            this.criterias = {
                Keywords: null,
                Category: null,
            };
            this.dom = {
                inputs: {
                    location: null,
                    search: null,
                }
            };
            this.typing = false;
            this.criterias.Keywords = new Criteria.Keyword(this.getProjectsByKeywords.bind(this));
            this.criterias.Category = new Criteria.Category(this.getProjectsByCategory.bind(this));
            this.GoogleMaps = new ProjectsList.GoogleMaps();
            this.UI = new ProjectsList.UI();
            this.events();
        }
        Core.prototype.events = function () {
            this.GoogleMaps.on(GmapsEvent.RETRIEVED, this.UI.buildProjects, this.UI);
            this.GoogleMaps.on(GmapsEvent.CLEAR, this.criterias.Keywords.clear, this.criterias.Keywords);
            this.GoogleMaps.on(GmapsEvent.NO_RESULT, this.UI.noResult, this.UI);
        };
        /**
         * Request API to retrieve projects with specified keywords
         */
        Core.prototype.getProjectsByKeywords = function (keywords) {
            Request.AJAX({
                'url': Build.api.keywords,
                'data': keywords,
                'success': this.success.bind(this)
            });
        };
        /**
         * Request API to retrieve projects with specified category
         */
        Core.prototype.getProjectsByCategory = function (category) {
            if (this.GoogleMaps.value.project_lat != 0 && this.GoogleMaps.value.project_lng != 0) {
                var data = {
                    category: category,
                    location: {
                        lat: this.GoogleMaps.value.project_lat,
                        lng: this.GoogleMaps.value.project_lng
                    }
                };
            }
            else {
                var data = category;
            }
            this.criterias.Keywords.clear();
            Request.AJAX({
                'url': Build.api.category,
                'data': data,
                'success': this.success.bind(this)
            });
        };
        /**
         * Success handler of getProjectsByKeywords | getProjectsByCategory request
         */
        Core.prototype.success = function (xhr) {
            if (xhr.success === true) {
                this.UI.buildProjects(xhr.projects);
                this.GoogleMaps.resetMarkers(xhr.projects);
                if (xhr.keywords_only === true) {
                    this.GoogleMaps.clear();
                    this.criterias.Category.clearCategories();
                }
            }
            else {
                this.UI.noResult(xhr.projects);
                this.GoogleMaps.resetMarkers(xhr.projects);
            }
        };
        return Core;
    })(Container);
    ProjectsList.Core = Core;
    var GoogleMaps = (function (_super) {
        __extends(GoogleMaps, _super);
        function GoogleMaps() {
            // GMAPS
            this.interval = 250;
            this.delay = 200;
            this.markers = [];
            this.infowindows = [];
            this.zoom = 6;
            this.intervalZooming = null;
            this.zoomIn = false;
            this.projects = null;
            // AUTOCOMPLETE
            this.value = {
                project_lat: 0,
                project_lng: 0,
            };
            // GM vars
            this.autocomplete = null;
            this.input = document.querySelector('input[name="location"]');
            this.listener();
            this.getProjects(_projects);
        }
        /**
         * Listen and detect if GM is ready to init autocomplete
         */
        GoogleMaps.prototype.listener = function () {
            this.instance = setInterval(function () {
                if (GMReady === true) {
                    clearInterval(this.instance);
                    this.initMap();
                    this.events();
                }
            }.bind(this), this.interval);
        };
        /**
         * Initialize events
         */
        GoogleMaps.prototype.events = function () {
            var _this = this;
            this.autocomplete = new google.maps.places.Autocomplete(this.input);
            this.input.addEventListener('focus', this.clear.bind(this));
            this.input.addEventListener('blur', function (e) {
                if (_this.input.val() == '')
                    _this.getProjectsByLocation();
            });
            this.autocomplete.addListener('place_changed', function () {
                // Retrieve place and lat/lng
                var places = this.autocomplete.getPlace();
                this.value.project_lat = places.geometry.location.lat();
                this.value.project_lng = places.geometry.location.lng();
                this.map.panTo(new google.maps.LatLng(this.value.project_lat, this.value.project_lng));
                this.emit(GmapsEvent.CLEAR);
                // Apply new values
                this.getProjectsByLocation(this.value);
            }.bind(this));
        };
        /**
         * Request API to retrieve projects with specified location
         */
        GoogleMaps.prototype.getProjectsByLocation = function (values) {
            Request.AJAX({
                'url': Build.api.location,
                'data': values,
                'success': this.successLocation.bind(this)
            });
        };
        GoogleMaps.prototype.successLocation = function (xhr) {
            if (xhr.success === true) {
                this.emit(GmapsEvent.RETRIEVED, xhr.projects);
                this.resetMarkers(xhr.projects);
            }
            else {
                this.emit(GmapsEvent.NO_RESULT, xhr.projects);
                this.resetMarkers(xhr.projects);
            }
        };
        /**
         * Restore default values of location
         */
        GoogleMaps.prototype.clear = function () {
            this.value.project_lat = 0;
            this.value.project_lng = 0;
            this.input.value = '';
        };
        /**
         * Store new projects list in class variable
         */
        GoogleMaps.prototype.getProjects = function (projects) {
            this.projects = projects;
        };
        /**
         * Bind markers click to open infoWindow
         */
        GoogleMaps.prototype.bindInfoWindow = function (marker, map, infowindow, html) {
            var self = this;
            marker.addListener('click', function () {
                infowindow.setContent(html);
                self.closeAllWindows();
                infowindow.open(map, this);
            });
            // CLEAN UP WHITE SPACES INFOWINDOW
            google.maps.event.addListener(infowindow, 'domready', function () {
                var iwOuter = document.querySelectorAll('#map .main-content');
                for (var i = 0; i < iwOuter.length; i++) {
                    var iwBackground = iwOuter[i].parentElement.parentElement.parentElement.previousSibling;
                    iwBackground.style.display = 'none';
                }
            });
        };
        GoogleMaps.prototype.closeAllWindows = function () {
            for (var i = 0; i < this.infowindows.length; i++) {
                this.infowindows[i].close();
                console.log(this.infowindows[i]);
            }
        };
        /**
         * Remove all markers and animate-in new Markers
         */
        GoogleMaps.prototype.resetMarkers = function (projects) {
            var self = this;
            this.getProjects(projects);
            this.clearMarkers();
            // LOOP THROUGH PROJECTS
            for (var i = 0; i < Object.keys(this.projects).length; i++) {
                var contentString = '<div class="main-content" style="font-size: 8px">' +
                    '<div class="project-detail">' +
                    '<div class="picture">' +
                    '<img src="' + this.projects[i].coverMid + '" alt="Image" />' +
                    '</div>' +
                    '<div class="content">' +
                    '<span class="title-4">' + this.projects[i].name + '</span>' +
                    '<div class="wrapper">' +
                    '<p class="text-2">' + this.projects[i].headline + '</p>' +
                    '<a class="border-btn" href="' + this.projects[i].linkSg + '">' +
                    'Découvrir le projet</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                var location = { lat: self.projects[i].lat, lng: self.projects[i].lng };
                var infowindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location.lat, location.lng),
                    map: self.map,
                    animation: google.maps.Animation.DROP,
                    title: self.projects[i].name
                });
                this.markers.push(marker);
                this.infowindows.push(infowindow);
                this.bindInfoWindow(marker, self.map, infowindow, contentString);
            }
        };
        /**
         * Create the map, set the markers and infoWindow contents
         */
        GoogleMaps.prototype.initMap = function () {
            var self = this;
            var centerView = { lat: 47.081425, lng: 2.396860 };
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf('MSIE ');
            var trident = ua.indexOf('Trident/');
            var edge = ua.indexOf('Edge/');
            var allowScroll = false;
            if (msie > 0)
                allowScroll = true;
            else if (trident > 0)
                allowScroll = true;
            else if (edge > 0)
                allowScroll = true;
            else
                allowScroll = false;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: this.zoom,
                center: centerView,
                disableDefaultUI: true,
                scrollwheel: allowScroll,
                zoomControl: true
            });
            this.map = map;
            // LOOP THROUGH PROJECTS
            for (var i = 0; i < Object.keys(this.projects).length; i++) {
                var contentString = '<div class="main-content" style="font-size: 8px">' +
                    '<div class="project-detail">' +
                    '<div class="picture">' +
                    '<img src="' + this.projects[i].coverMid + '" alt="Image" />' +
                    '</div>' +
                    '<div class="content">' +
                    '<span class="title-4">' + this.projects[i].name + '</span>' +
                    '<div class="wrapper">' +
                    '<p class="text-2">' + this.projects[i].headline + '</p>' +
                    '<a class="border-btn" href="' + this.projects[i].linkSg + '">' +
                    'Découvrir le projet</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                var location = { lat: self.projects[i].lat, lng: self.projects[i].lng };
                var infowindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location.lat, location.lng),
                    map: map,
                    animation: google.maps.Animation.DROP,
                    title: self.projects[i].name
                });
                this.markers.push(marker);
                this.infowindows.push(infowindow);
                this.bindInfoWindow(marker, map, infowindow, contentString);
            }
        };
        /**
         * Remove markers
         */
        GoogleMaps.prototype.clearMarkers = function () {
            for (var i = 0; i < this.markers.length; i++) {
                this.markers[i].setMap(null);
            }
            this.markers = new Array();
        };
        return GoogleMaps;
    })(EventEmitter);
    ProjectsList.GoogleMaps = GoogleMaps;
    var UI = (function () {
        function UI() {
            this.dom = {
                body: null,
                wrapper: null,
                projects: null,
                loadMore: null,
                search: null,
            };
            this.delay = 50; // inject animation delay
            this.dom.body = document.querySelector('body');
            this.dom.wrapper = this.dom.body.find('.main-wrapper .container-projects');
            //this.dom.loadMore = this.dom.body.find('.red-btn.load-more');
            this.dom.search = this.dom.body.find('.js-search');
            this.events();
        }
        /**
         * Initialize events
         */
        UI.prototype.events = function () {
            var _this = this;
            this.dom.search.addEventListener('click', function (e) {
                _this.scrollToResults();
            });
        };
        /**
         * Scroll to projects
         */
        UI.prototype.scrollToResults = function () {
            var offset = (this.dom.wrapper.offsetTop - 200);
            TweenMax.to(window, 0.5, { scrollTo: { y: offset }, ease: Power3.easeInOut });
        };
        /**
         * Build projects HTML
         */
        UI.prototype.buildProjects = function (projects, more) {
            if (typeof projects == 'object') {
                var html = '';
                //this.dom.loadMore.remove();
                if (more != true)
                    html = '<div class="list-projects">';
                for (var i = 0; i < projects.length; i++) {
                    html += '<div class="project animate-out" data-category="' + projects[i].category.id + '">';
                    html += '<div class="image" style="background-image: url(' + projects[i].coverMid + ')">';
                    html += '<span class="category">' + projects[i].category.name + '</span>';
                    html += '</div>';
                    html += '<div class="description">';
                    html += '<span class="location">' + projects[i].city + ' - ' + projects[i].zipcode + '</span>';
                    html += '<h3 class="title-4">' + projects[i].name + '</h3>';
                    html += '<p class="text-1">';
                    html += projects[i].headline;
                    html += '</p>';
                    html += '<a href="' + projects[i].linkSg + '" title="Découvrez ' + projects[i].name + '" class="border-btn">';
                    html += '<span class="icon-arrow-right">';
                    html += '<img src="' + pathAsset + '/img/generics/icon-arrow.png" alt="Chevron" />';
                    html += '</span>';
                    html += '<span class="btn-text">Découvrez ce projet</span>';
                    html += '</a>';
                    html += '</div>';
                    html += '</div>';
                }
                if (more != true)
                    html += '</div>';
                //if(projects.length > 8 && more != true)
                //{
                //    html += '<a href="javascript:;" data-label="Chargez plus de projet" rel="nofollow" title="Chargez plus de projet" class="red-btn load-more">Chargez plus de projet </a>';
                //
                //}
                if (more === true) {
                    var oldHtml = this.dom.wrapper.find('.list-projects');
                    oldHtml.insertAdjacentHTML('beforeend', html);
                }
                else {
                    this.dom.wrapper.innerHTML = html;
                }
                this.animateProjects();
            }
            else {
                this.noResult(projects);
            }
        };
        /**
         * Bind | Re-bind loadMore btn injected
         */
        UI.prototype.bindLoadMore = function () {
            //this.dom.loadMore = this.dom.body.find('.red-btn.load-more');
            //
            //this.dom.loadMore.addEventListener('click', (e: Event) => {
            //    this.getMoreProjects();
            //});
        };
        /**
         * Retrieve more projects from the API
         */
        UI.prototype.getMoreProjects = function () {
            Request.AJAX({
                'url': Build.api.load_more,
                'data': '',
                'success': this.successMoreProjects.bind(this)
            });
        };
        /**
         * Manage getMoreProjects request's response
         */
        UI.prototype.successMoreProjects = function (xhr) {
            this.buildProjects(xhr.projects, true);
        };
        /**
         * Animate/show projects cards
         */
        UI.prototype.animateProjects = function () {
            var items = this.dom.wrapper.findAll('.project.animate-out');
            for (var i = 0; i < items.length; i++) {
                setTimeout(function () {
                    this.removeClass('animate-out');
                }.bind(items[i]), this.delay * i);
            }
        };
        /**
         * Build | Inject no project found message
         */
        UI.prototype.noResult = function (message) {
            var html = '<div class="list-projects">';
            html += '<p class="no-result">' + message + '</p>';
            html += '</div>';
            //this.dom.loadMore.remove();
            this.dom.wrapper.innerHTML = html;
        };
        return UI;
    })();
    ProjectsList.UI = UI;
})(ProjectsList || (ProjectsList = {}));
var ProjectsSingle;
(function (ProjectsSingle) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
            this.dom = {
                percentage: null,
                circle: null,
                captcha: null,
                partRight: {
                    container: null,
                    voteBtn: null,
                    facebookBtn: null,
                    rulesBtn: null,
                    counter: null
                },
                ipLabel: null
            };
            this.user = {
                idConnect: null,
                type: null,
                voteType: "CLASSIC",
                email: null,
                projectId: null,
                lastname: null,
                firstname: null,
                recaptcha: null,
            };
            this.data = null;
            // FB
            this.fb = {
                link: null,
                title: null,
                caption: null,
                description: null,
                picture: null,
            };
            this.token = null;
            this.getDOM();
            this.initEvents();
            this.initializeClasses();
            this.checkFbLogged();
        }
        Core.prototype.checkFbLogged = function () {
            var self = this;
            FB.getLoginStatus(function (response) {
                if (response.status === 'connected') {
                    self.token = response.authResponse.accessToken;
                }
                else {
                    console.log("not connected to fb");
                }
            });
        };
        /**
         * Retrieve DOM Elements
         */
        Core.prototype.getDOM = function () {
            // this.dom.circle = document.querySelector('.red-circle #bar');
            this.dom.percentage = document.querySelector('.percentage');
            this.dom.partRight.container = document.querySelector('.js-part-right');
            this.dom.partRight.voteBtn = this.dom.partRight.container.find('.js-vote-btn');
            this.dom.partRight.facebookBtn = this.dom.partRight.container.find('.facebook');
            this.dom.partRight.rulesBtn = this.dom.partRight.container.find('.js-rules-btn');
            this.dom.partRight.counter = this.dom.partRight.container.find('.vote-number');
            this.dom.ipLabel = document.querySelector('.popin.banned .to-replace');
        };
        /**
         * Initialize events
         */
        Core.prototype.initEvents = function () {
            var _this = this;
            this.dom.partRight.voteBtn.addEventListener('click', function () {
                _this.Generics.openPopin('connexion');
                _this.user.projectId = _this.dom.partRight.voteBtn.getAttribute('data-project');
            });
            document.body.delegate('click', '.js-facebook-btn', function (e, el) {
                _this.user.projectId = el.getAttribute('data-project');
                _this.fb.picture = el.getAttribute('data-fb-img');
                _this.fb.link = el.getAttribute('data-fb-link');
                _this.fb.caption = el.getAttribute('data-fb-link');
                _this.fb.description = el.getAttribute('data-fb-caption');
                _this.fb.title = el.getAttribute('data-fb-title');
                _this.shareFb();
            });
            this.dom.partRight.rulesBtn.addEventListener('click', function () {
                _this.Generics.openPopin('rules');
            });
            this.Generics.dom.popins.connexion.cta.addEventListener('click', function () {
                _this.user.type = "MAIL";
                _this.user.voteType = "CLASSIC";
                _this.Generics.dom.popins.connexion.errorMessage.innerHTML = 'Veuillez saisir une adresse email valide.';
                _this.process('connexion');
            });
            this.Generics.dom.popins.connexion.facebook.addEventListener('click', function () {
                _this.user.type = "FACEBOOK";
                _this.user.voteType = "CLASSIC";
                _this.logFb();
            });
            this.Generics.dom.popins.form.cta.addEventListener('click', function () {
                _this.process('form');
            });
            // Format date input
            this.Generics.dom.popins.form.birthdate.addEventListener('focus', function (e) {
                if (!_this.Generics.dom.popins.form.birthdate.val())
                    _this.Generics.dom.popins.form.birthdate.placeholder = 'JJ/MM/YYYY';
            });
            this.Generics.dom.popins.form.birthdate.addEventListener('blur', function (e) {
                if (!_this.Generics.dom.popins.form.birthdate.val() || _this.Generics.dom.popins.form.birthdate.val())
                    _this.Generics.dom.popins.form.birthdate.placeholder = 'Date de naissance*';
            });
            this.Generics.dom.popins.form.birthdate.addEventListener('keyup', function (e) {
                // Check for slash keypress and already positionned slashes.
                if (e.which === 191 || e.which === 111) {
                    if (_this.Generics.dom.popins.form.birthdate.val().charAt((_this.Generics.dom.popins.form.birthdate.val().length - 1)) === '/') {
                        e.preventDefault();
                        return;
                    }
                }
                if (e.which !== 8) {
                    var numChars = _this.Generics.dom.popins.form.birthdate.val().length;
                    if (numChars === 2 || numChars === 5) {
                        var thisVal = _this.Generics.dom.popins.form.birthdate.val();
                        thisVal += '/';
                        _this.Generics.dom.popins.form.birthdate.value = thisVal;
                    }
                }
            });
            this.Generics.dom.popins.form.birthdate.addEventListener('keydown', function (e) {
                if (e.which === 191 || e.which === 111) {
                    e.preventDefault();
                    return;
                }
                if (e.which !== 8) {
                    var numChars = _this.Generics.dom.popins.form.birthdate.val().length;
                    if (numChars === 2 || numChars === 5) {
                        var thisVal = _this.Generics.dom.popins.form.birthdate.val();
                        thisVal += '/';
                        _this.Generics.dom.popins.form.birthdate.value = thisVal;
                    }
                }
            });
            if (this.dom.partRight.container.getAttribute('data-activate')) {
                this.Generics.openPopin('voted');
            }
        };
        Core.prototype.initializeClasses = function () {
            this.FormPopinConnexion = new FormValidator({
                'target': this.Generics.dom.popins.connexion.container,
                'inputs': this.Generics.dom.popins.connexion.inputs,
                'parent': true
            });
            this.FormPopinForm = new FormValidator({
                'target': this.Generics.dom.popins.form.container,
                'inputs': this.Generics.dom.popins.form.inputs,
                'parent': true
            });
            FB.init({
                appId: '295315457533652',
                cookie: true,
                status: true,
                xfbml: true,
                version: 'v2.8'
            });
        };
        Core.prototype.shareFb = function () {
            var self = this;
            FB.getLoginStatus(function (response) {
                if (response.status === 'connected') {
                    self.token = response.authResponse.accessToken;
                    // Simply go on process
                    FB.ui({
                        // method: 'feed',
                        // link: self.fb.link,
                        // name: self.fb.title,
                        // description: self.fb.description,
                        // caption: self.fb.caption,
                        // picture: self.fb.picture,
                        method: 'share_open_graph',
                        action_type: 'og.shares',
                        display: 'popup',
                        action_properties: JSON.stringify({
                            object: {
                                'og:url': self.fb.link,
                                'og:title': self.fb.title,
                                'og:description': self.fb.description,
                                'og:image': self.fb.picture,
                            }
                        })
                    }, function (response) {
                        if (typeof response != 'undefined') {
                            FB.api('/me', { access_token: self.token, fields: 'last_name, email, first_name' }, function (response) {
                                if (!response.hasOwnProperty('error')) {
                                    self.user.idConnect = response.id;
                                    self.user.firstname = response.first_name;
                                    self.user.lastname = response.last_name;
                                    self.user.email = response.email;
                                    self.user.voteType = 'SHARE';
                                    self.user.type = 'FACEBOOK';
                                    self.checkShared();
                                }
                                else {
                                    console.warn("L'utilisateur n'a pas partagé.");
                                }
                            });
                        }
                        else
                            console.warn("L'utilisateur n'a pas partagé.");
                    });
                }
                else if (response.status === 'not_authorized') {
                    // Call re-authorize action before go on process
                    FB.login(function (response) {
                        // Re authenticate
                    }, { auth_type: 'reauthenticate' });
                }
                else {
                    // Log the user and go on process
                    FB.login(function (response) {
                        // Login
                    }, { scope: 'public_profile, email' });
                }
            });
        };
        Core.prototype.checkShared = function () {
            Request.AJAX({
                'url': Build.api.shared_register,
                'data': this.user,
                'success': this.responseShared.bind(this)
            });
        };
        Core.prototype.responseShared = function (xhr) {
            var self = this;
            if (xhr.success === true) {
                self.user.voteType = 'SHARE';
                self.requestSharedVote();
            }
            else {
                this.Generics.openPopin('shared');
            }
        };
        Core.prototype.requestSharedVote = function () {
            Request.AJAX({
                'url': Build.api.shared_vote,
                'data': this.user,
                'success': this.responseSharedVote.bind(this)
            });
        };
        Core.prototype.responseSharedVote = function (xhr) {
            if (xhr.success === true) {
                this.Generics.closePopin('voted');
                this.updateTotalVote(xhr.total_vote);
            }
        };
        Core.prototype.updateTotalVote = function (nbVote) {
            this.dom.partRight.counter.innerHTML = nbVote;
        };
        Core.prototype.logFb = function () {
            var self = this;
            FB.login(function (response) {
                if (response.authResponse) {
                    FB.api('/me', { fields: 'last_name, email, first_name' }, function (response) {
                        self.user.firstname = response.first_name;
                        self.user.lastname = response.last_name;
                        self.user.idConnect = response.id;
                        self.process('connexion');
                    });
                }
                else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, { scope: 'public_profile, email' });
        };
        /**
         * Process Form Validation
         */
        Core.prototype.process = function (step) {
            switch (step) {
                case 'connexion':
                    if (this.user.type == 'MAIL') {
                        if (this.FormPopinConnexion.isValid())
                            this.user.idConnect = this.Generics.dom.popins.connexion.email.val();
                        else {
                            this.Generics.dom.popins.connexion.errorMessage.parentNode.addClass('error');
                            return;
                        }
                        // RECAPTCHA
                        this.dom.captcha = document.getElementById("g-recaptcha-response");
                        if (this.dom.captcha.value != '') {
                            this.user.recaptcha = this.dom.captcha.value;
                            this.Generics.dom.popins.connexion.errorMessage.parentNode.removeClass('error');
                        }
                        else {
                            this.Generics.dom.popins.connexion.errorMessage.innerHTML = 'Veuillez confirmer que vous n\'êtes pas un robot.';
                            this.Generics.dom.popins.connexion.errorMessage.parentNode.addClass('error');
                            return;
                        }
                    }
                    Request.AJAX({
                        'url': Build.api.vote,
                        'data': this.user,
                        'success': this.responseConnexion.bind(this)
                    });
                    break;
                case 'form':
                    if (this.FormPopinForm.isValid()) {
                        this.data = this.FormPopinForm.getData();
                        Request.AJAX({
                            'url': Build.api.register,
                            'data': this.data,
                            'success': this.responseForm.bind(this)
                        });
                    }
                    break;
                default:
                    break;
            }
        };
        Core.prototype.responseConnexion = function (xhr) {
            if (xhr.to_register === true) {
                this.closePopin('connexion');
                if (this.user.type === 'FACEBOOK')
                    this.injectForm();
                else
                    this.Generics.dom.popins.form.email.value = this.Generics.dom.popins.connexion.email.val();
                this.openPopin('form');
            }
            else if (xhr.already_voted === true) {
                this.Generics.dom.popins.connexion.errorMessage.innerHTML = xhr.message;
                this.Generics.dom.popins.connexion.errorMessage.parentNode.addClass('error');
            }
            else if (xhr.user_inactive === true) {
                this.closePopin('connexion');
                this.openPopin('need_activate');
            }
            else if (xhr.recaptcha_validate === false) {
                this.Generics.dom.popins.connexion.errorMessage.innerHTML = xhr.message;
                this.Generics.dom.popins.connexion.errorMessage.parentNode.addClass('error');
            }
            else if (xhr.banned === true) {
                this.closePopin('connexion');
                this.dom.ipLabel.html(xhr.ip);
                this.openPopin('banned');
            }
            else {
                this.closePopin('connexion');
                if (xhr.type && xhr.type == 'FACEBOOK') {
                    this.updateTotalVote(xhr.total_vote);
                    this.openPopin('voted');
                }
                else
                    this.openPopin('need_activate');
            }
        };
        Core.prototype.injectForm = function () {
            this.Generics.dom.popins.form.name.value = this.user.lastname;
            this.Generics.dom.popins.form.firstname.value = this.user.firstname;
            this.Generics.dom.popins.form.email.value = this.user.email;
        };
        Core.prototype.responseForm = function (xhr) {
            if (xhr.success) {
                this.closePopin('form');
                // this.updateTotalVote(xhr.total_vote);
                if (xhr.type && xhr.type == 'FACEBOOK') {
                    this.updateTotalVote(xhr.total_vote);
                    this.openPopin('voted');
                }
                else
                    this.openPopin('first_subscribe');
            }
            else if (xhr.banned === true) {
                this.closePopin('form');
                this.dom.ipLabel.html(xhr.ip);
                this.openPopin('banned');
            }
        };
        Core.prototype.openPopin = function (popin) {
            var el = this.Generics.dom.popins[popin].container;
            TweenMax.fromTo(el, this.Generics.duration.open, { left: '150%' }, { left: '0%', ease: Power3.ease, onStart: function () {
                    el.removeClass('hide');
                    el.style.top = '50%';
                } });
        };
        Core.prototype.closePopin = function (popin) {
            var el = this.Generics.dom.popins[popin].container;
            TweenMax.fromTo(el, this.Generics.duration.close, { left: '0%' }, { left: '-150%', ease: Power3.ease, onComplete: function () {
                    el.addClass('hide');
                    el.style.top = '50%';
                } });
        };
        return Core;
    })(Container);
    ProjectsSingle.Core = Core;
})(ProjectsSingle || (ProjectsSingle = {}));
var Closed;
(function (Closed) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
        }
        return Core;
    })(Container);
    Closed.Core = Core;
})(Closed || (Closed = {}));
var HomeIndex;
(function (HomeIndex) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
            this.dom = {
                slider: {
                    container: null,
                    slides: [],
                    stagger: []
                },
                arrows: {
                    previous: null,
                    next: null
                }
            };
            this.duration = {
                show: .2,
                hide: .3,
                stagger: .03
            };
            this.swipe = {
                startX: null,
            };
            this.currentId = 0;
            this.direction = 1;
            // this.getDOM();
            // this.initializeEvents();
        }
        /**
         * Retrieve DOM
         */
        Core.prototype.getDOM = function () {
            this.dom.slider.container = document.querySelector('.slider');
            this.dom.slider.slides = this.dom.slider.container.findAll('.slide');
            for (var i = 0, j = this.dom.slider.slides.length; i < j; i++) {
                this.dom.slider.stagger[i] = this.dom.slider.container.findAll(".js-stagger-" + i);
            }
            this.dom.arrows.previous = this.dom.slider.container.find('.previous');
            this.dom.arrows.next = this.dom.slider.container.find('.next');
        };
        /**
         * Initialize generics events
         */
        Core.prototype.initializeEvents = function () {
            var _this = this;
            this.dom.arrows.previous.addEventListener('click', function () {
                _this.direction = -1;
                _this.hide(_this.dom.slider.slides[_this.currentId]);
                if (_this.currentId === 0)
                    _this.currentId = _this.dom.slider.slides.length - 1;
                else
                    _this.currentId--;
                _this.show(_this.dom.slider.slides[_this.currentId]);
            });
            this.dom.arrows.next.addEventListener('click', function () {
                _this.direction = 1;
                _this.hide(_this.dom.slider.slides[_this.currentId]);
                if (_this.currentId === _this.dom.slider.slides.length - 1)
                    _this.currentId = 0;
                else
                    _this.currentId++;
                _this.show(_this.dom.slider.slides[_this.currentId]);
            });
            // INIT SWIPE
            this.dom.slider.container.addEventListener('touchstart', function (e) {
                _this.swipe.startX = e.changedTouches[0].pageX;
            });
            this.dom.slider.container.addEventListener('touchend', function (e) {
                var x = e.changedTouches[0].pageX;
                if ((x > _this.swipe.startX) && ((x - _this.swipe.startX) > 60)) {
                    _this.direction = -1;
                    _this.hide(_this.dom.slider.slides[_this.currentId]);
                    if (_this.currentId === 0)
                        _this.currentId = _this.dom.slider.slides.length - 1;
                    else
                        _this.currentId--;
                    _this.show(_this.dom.slider.slides[_this.currentId]);
                }
                else if ((x < _this.swipe.startX) && ((x - _this.swipe.startX) < -60)) {
                    _this.direction = 1;
                    _this.hide(_this.dom.slider.slides[_this.currentId]);
                    if (_this.currentId === _this.dom.slider.slides.length - 1)
                        _this.currentId = 0;
                    else
                        _this.currentId++;
                    _this.show(_this.dom.slider.slides[_this.currentId]);
                }
            });
        };
        Core.prototype.show = function (el) {
            if (el !== undefined) {
                el.addClass('show');
                el.removeClass('hide');
                TweenMax.staggerFromTo(this.dom.slider.stagger[this.currentId], this.duration.show, { x: 200 * this.direction, opacity: 0 }, { x: 0, opacity: 1 }, this.duration.stagger);
                TweenMax.fromTo(el, this.duration.show, { x: 300 * this.direction, opacity: 0 }, { x: 0, opacity: 1, ease: Power3.easeOut });
            }
        };
        Core.prototype.hide = function (el) {
            if (el !== undefined) {
                TweenMax.fromTo(el, this.duration.hide, { x: 0, opacity: 1 }, { x: -300 * this.direction, opacity: 0, ease: Power3.easeOut, onComplete: function () {
                        el.addClass('hide');
                        el.removeClass('show');
                    } });
            }
        };
        return Core;
    })(Container);
    HomeIndex.Core = Core;
})(HomeIndex || (HomeIndex = {}));
var HomeRegister;
(function (HomeRegister) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
            this.Animation = new HomeRegister.Animation();
        }
        return Core;
    })(Container);
    HomeRegister.Core = Core;
    var Animation = (function () {
        function Animation() {
            this.dom = {
                container: null,
                items: null,
            };
            this.timing = [];
            this.dom.container = document.querySelector('.container.container-2');
            this.dom.items = this.dom.container.findAll('.step');
            this.init();
            this.listener();
        }
        Animation.prototype.init = function () {
            for (var i = 0; i < this.dom.items.length; i++) {
                this.timing[i] = this.dom.items[i].offsetTop + 400;
            }
        };
        Animation.prototype.listener = function () {
            var _this = this;
            window.addEventListener('scroll', function (e) {
                for (var i = 0; i < _this.timing.length; i++) {
                    if (window.scrollY >= _this.timing[i])
                        _this.dom.items[i].addClass('animate-in');
                }
            });
            window.addEventListener('mousewheel', function (e) {
                for (var i = 0; i < _this.timing.length; i++) {
                    if (window.scrollY >= _this.timing[i])
                        _this.dom.items[i].addClass('animate-in');
                }
            });
        };
        return Animation;
    })();
    HomeRegister.Animation = Animation;
})(HomeRegister || (HomeRegister = {}));
var About;
(function (About) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
        }
        return Core;
    })(Container);
    About.Core = Core;
})(About || (About = {}));
var Rules;
(function (Rules) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
            console.warn('Rules::Core - ctr');
        }
        return Core;
    })(Container);
    Rules.Core = Core;
})(Rules || (Rules = {}));
var Presubscribe;
(function (Presubscribe) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
            this.dom = {
                form: null,
                inputs: [],
                btn: null,
                rowRadio: null,
                radio: null,
                wrapperEmail: null,
                msgEmail: null,
                optin: null
            };
            this.getDOM();
            this.Form = new FormValidator({
                'target': this.dom.form,
                'inputs': this.dom.inputs,
                'parent': true
            });
            this.initEvents();
        }
        /**
         * Retrieve DOM Elements
         */
        Core.prototype.getDOM = function () {
            this.dom.form = this.wrapper.find('.container form');
            this.dom.inputs = this.dom.form.findAll('input.input-text');
            this.dom.btn = this.wrapper.find('.validate-btn');
            this.dom.rowRadio = this.wrapper.find('.row-radio');
            this.dom.radio = this.dom.rowRadio.findAll('.input-radio');
            this.dom.wrapperEmail = this.wrapper.find('.row.email');
            this.dom.msgEmail = this.wrapper.find('.message-email');
            this.dom.optin = this.wrapper.find('.optin');
        };
        /**
         * Initialize events
         */
        Core.prototype.initEvents = function () {
            this.dom.btn.addEventListener('click', function (e) {
                e.preventDefault();
                this.process();
            }.bind(this));
        };
        /**
         * Retrieve radio value
         * If the value is not set it returns null
         * @returns {any}
         */
        Core.prototype.getRadioValue = function () {
            for (var i = 0; i < this.dom.radio.length; i++) {
                var radio = this.dom.radio[i];
                if (radio.checked)
                    return (radio.getAttribute('value') === 'true');
            }
            return null;
        };
        /**
         * Process Form Validation
         */
        Core.prototype.process = function () {
            this.dom.rowRadio.removeClass('error');
            if (this.Form.isValid()) {
                var radio = this.getRadioValue();
                // Check radio
                if (radio === null) {
                    this.dom.rowRadio.addClass('error');
                    return;
                }
                var data = this.Form.getData();
                data.already_exists = radio;
                data.optin = this.dom.optin.checked;
                Request.AJAX({
                    'url': Build.api.presubscribe,
                    'data': data,
                    'success': this.response.bind(this)
                });
            }
        };
        /**
         * Manage response
         * @param xhr
         */
        Core.prototype.response = function (xhr) {
            if (xhr.success === true)
                document.location.href = xhr.redirect;
            else {
                this.injectWarning(xhr.message);
            }
        };
        Core.prototype.injectWarning = function (message) {
            this.dom.msgEmail.innerHTML = message;
            this.dom.wrapperEmail.addClass('error');
        };
        return Core;
    })(Container);
    Presubscribe.Core = Core;
})(Presubscribe || (Presubscribe = {}));
var Subscribe;
(function (Subscribe) {
    var Core = (function (_super) {
        __extends(Core, _super);
        function Core() {
            _super.call(this);
            this.dom = {
                formOne: {
                    form: null,
                    inputs: [],
                    btn: null,
                    pwd: null,
                    confirmPwd: null,
                },
                formTwo: {
                    form: null,
                    inputs: [],
                    description: null,
                    tellUsAbout: null,
                    aimText: null,
                    date: null,
                    partner: null,
                    btn: null,
                    category: null,
                },
                rules: null,
                validate: null,
            };
            this.data = null;
            this.UI = new Subscribe.UI();
            this.getDOM();
            this.initClasses();
        }
        Core.prototype.initClasses = function () {
            this.FormOne = new FormValidator({
                'target': this.dom.formOne.form,
                'inputs': this.dom.formOne.inputs,
                'parent': true
            });
            this.FormTwo = new FormValidator({
                'target': this.dom.formTwo.form,
                'inputs': this.dom.formTwo.inputs,
                'parent': true
            });
        };
        /**
         * Retrieve DOM Elements
         */
        Core.prototype.getDOM = function () {
            // STEP 1
            this.dom.formOne.form = this.wrapper.find('.form-container-1');
            this.dom.formOne.inputs = this.dom.formOne.form.findAll('input.input-text');
            this.dom.formOne.btn = this.dom.formOne.form.find('.validate-btn');
            this.dom.formOne.pwd = this.dom.formOne.form.find('[name="password"]');
            this.dom.formOne.confirmPwd = this.dom.formOne.form.find('[name="password-confirm"]');
            // STEP 2
            this.dom.formTwo.form = this.wrapper.find('.form-container-2');
            this.dom.formTwo.inputs = this.dom.formTwo.form.findAll('input.input-text');
            this.dom.formTwo.description = this.dom.formTwo.form.find('[name="description"]');
            this.dom.formTwo.tellUsAbout = this.dom.formTwo.form.find('[name="counterparties"]');
            this.dom.formTwo.aimText = this.dom.formTwo.form.find('[name="communication"]');
            this.dom.formTwo.date = this.dom.formTwo.form.find('[name="date"]');
            this.dom.formTwo.partner = this.dom.formTwo.form.find('[name="partner"]');
            this.dom.formTwo.btn = this.dom.formTwo.form.find('.validate-btn');
            this.dom.formTwo.category = this.dom.formTwo.form.find('#category');
            this.dom.validate = this.wrapper.find('.js-validate-btn');
            this.dom.rules = this.wrapper.find('#rules');
            this.initEvents();
        };
        /**
         * Initialize events
         */
        Core.prototype.initEvents = function () {
            var _this = this;
            // Popin rules
            this.UI.dom.rules.addEventListener('click', function () {
                _this.Generics.openPopin('rules');
            });
            this.dom.formOne.btn.addEventListener('click', function (e) {
                e.preventDefault();
                this.process('first');
            }.bind(this));
            this.dom.formTwo.btn.addEventListener('click', function (e) {
                e.preventDefault();
                this.process('second');
            }.bind(this));
            this.dom.validate.addEventListener('click', function (e) {
                e.preventDefault();
                this.process('third');
            }.bind(this));
            // Format date input
            this.dom.formTwo.date.addEventListener('focus', function (e) {
                if (!_this.dom.formTwo.date.val())
                    _this.dom.formTwo.date.placeholder = 'JJ/MM/YYYY';
            });
            this.dom.formTwo.date.addEventListener('blur', function (e) {
                if (!_this.dom.formTwo.date.val() || _this.dom.formTwo.date.val())
                    _this.dom.formTwo.date.placeholder = 'Quand aurez-vous besoin des fonds ?';
            });
            this.dom.formTwo.date.addEventListener('keyup', function (e) {
                // Check for slash keypress and already positionned slashes.
                if (e.which === 191 || e.which === 111) {
                    if (_this.dom.formTwo.date.val().charAt((_this.dom.formTwo.date.val().length - 1)) === '/') {
                        e.preventDefault();
                        return;
                    }
                }
                if (e.which !== 8) {
                    var numChars = _this.dom.formTwo.date.val().length;
                    if (numChars === 2 || numChars === 5) {
                        var thisVal = _this.dom.formTwo.date.val();
                        thisVal += '/';
                        _this.dom.formTwo.date.value = thisVal;
                    }
                }
            });
            this.dom.formTwo.date.addEventListener('keydown', function (e) {
                if (e.which === 191 || e.which === 111) {
                    e.preventDefault();
                    return;
                }
                if (e.which !== 8) {
                    var numChars = _this.dom.formTwo.date.val().length;
                    if (numChars === 2 || numChars === 5) {
                        var thisVal = _this.dom.formTwo.date.val();
                        thisVal += '/';
                        _this.dom.formTwo.date.value = thisVal;
                    }
                }
            });
        };
        Core.prototype.checkPassword = function () {
            if (this.dom.formOne.pwd.val() === this.dom.formOne.confirmPwd.val()) {
                this.dom.formOne.confirmPwd.parentNode.removeClass('error');
                return true;
            }
            else {
                this.dom.formOne.confirmPwd.parentNode.addClass('error');
                return false;
            }
        };
        /**
         * Process Form Validation
         */
        Core.prototype.process = function (step) {
            if (step == 'first') {
                if (this.FormOne.isValid() && this.checkPassword()) {
                    this.data = this.FormOne.getData();
                    this.UI.switchForm('next');
                }
            }
            else if (step == 'second') {
                if (this.FormTwo.isValid()) {
                    //this.data = Object.assign(this.data, this.FormTwo.getData());
                    var newData = this.FormTwo.getData();
                    for (var attrname in newData) {
                        this.data[attrname] = newData[attrname];
                    }
                    //data.optin = this.dom.optin.checked;
                    this.data.description = this.dom.formTwo.description.val();
                    this.data.tell_us_about = this.dom.formTwo.tellUsAbout.val();
                    this.data.aim_text = this.dom.formTwo.aimText.val();
                    this.data.partner = this.dom.formTwo.partner.val();
                    if (this.dom.formTwo.category.options.selectedIndex == 0) {
                        this.dom.formTwo.category.parentNode.parentNode.addClass('error');
                        return;
                    }
                    else {
                        this.dom.formTwo.category.parentNode.parentNode.removeClass('error');
                        this.data.category = this.dom.formTwo.category.options[this.dom.formTwo.category.options.selectedIndex].value;
                    }
                    Request.AJAX({
                        'url': Build.api.project,
                        'data': this.data,
                        'success': this.response.bind(this)
                    });
                }
            }
            else if (step == 'third') {
                if (this.dom.rules.checked === true) {
                    this.dom.rules.parentNode.removeClass('error');
                    Request.AJAX({
                        'url': Build.api.subscribe,
                        'data': this.data,
                        'success': this.success.bind(this)
                    });
                }
                else {
                    this.dom.rules.parentNode.addClass('error');
                }
            }
        };
        /**
         * Manage response
         * @param xhr
         */
        Core.prototype.response = function (xhr) {
            if (xhr.success === true)
                this.UI.buildResume(xhr);
            else
                console.warn(xhr.message);
        };
        /**
         * Manage final request
         * @param xhr
         */
        Core.prototype.success = function (xhr) {
            if (xhr.success === true)
                this.Generics.openPopin('submitted');
            else
                console.warn(xhr.message);
        };
        return Core;
    })(Container);
    Subscribe.Core = Core;
    var UI = (function () {
        function UI() {
            this.dom = {
                wrapper: null,
                timelines: null,
                modify: null,
                form: {
                    wrapper: null,
                    slides: null,
                },
                resume: null,
                rules: null,
            };
            this.duration = {
                wrapper: 0.4,
                slides: 0.4,
            };
            this.heights = [];
            this.wSlide = null;
            this.hSlide = null;
            this.nbSlide = null;
            this.padding = 10;
            this.currentStep = 0;
            this.getDOM();
            this.init();
        }
        UI.prototype.getDOM = function () {
            this.dom.wrapper = document.querySelector('.main-wrapper');
            this.dom.timelines = this.dom.wrapper.findAll('.timeline-number');
            this.dom.modify = this.dom.wrapper.find('.js-modify-btn');
            this.dom.form.wrapper = this.dom.wrapper.find('.form-wrapper');
            this.dom.form.slides = this.dom.form.wrapper.findAll('.form-container');
            this.dom.resume = this.dom.wrapper.find('.confirmation .resume');
            this.dom.rules = this.dom.wrapper.find('.cta-rules');
        };
        UI.prototype.init = function () {
            var _this = this;
            // Check for current step in DOM
            this.currentStep = parseInt(this.dom.form.wrapper.getAttribute('data-current-step'));
            // TIMELINE
            this.dom.timelines[this.currentStep].addClass('current');
            // VARS
            this.wSlide = this.dom.form.slides[0].offsetWidth;
            this.hSlide = this.dom.form.slides[0].offsetHeight;
            this.nbSlide = this.dom.form.slides.length;
            for (var i = 0; i < (this.nbSlide); i++) {
                this.heights[i] = (this.dom.form.slides[i].offsetHeight + 10);
                if (i != this.currentStep)
                    this.dom.form.slides[i].style.display = 'none';
                else
                    this.dom.form.slides[i].removeClass('hide');
            }
            this.dom.form.wrapper.style.height = this.heights[this.currentStep] + this.padding + 'px';
            // Back to previous step
            if (this.dom.modify) {
                this.dom.modify.addEventListener('click', function () {
                    _this.switchForm('previous');
                });
            }
        };
        UI.prototype.switchForm = function (direction) {
            if (direction === 'next' && this.currentStep < this.nbSlide)
                var next = this.currentStep + 1;
            else if (direction === 'previous' && this.currentStep != 0)
                var next = this.currentStep - 1;
            this.hSlide = this.heights[next] + this.padding + 'px';
            if (direction === 'next') {
                TweenMax.to(window, 0.3, { scrollTo: { y: 200 }, ease: Power3.easeInOut, onComplete: function () {
                        // Animate wrapper height
                        TweenMax.to(this.dom.form.wrapper, this.duration.wrapper, { height: this.hSlide, ease: Power3.easeInOut });
                        // Set current timeline
                        this.dom.timelines[this.currentStep].removeClass('current');
                        this.dom.timelines[next].addClass('current');
                        // Animate passed Form
                        TweenMax.to(this.dom.form.slides[this.currentStep], this.duration.slides, { left: '-100vw', ease: Power3.easeOut, onComplete: function () {
                                this.dom.form.slides[this.currentStep].style.display = 'none';
                            }.bind(this) });
                        // Animate next form
                        TweenMax.fromTo(this.dom.form.slides[next], this.duration.slides, { left: '100vw' }, { left: 0, ease: Power3.easeIn, onStart: function () {
                                this.dom.form.slides[next].style.display = 'block';
                                this.dom.form.slides[next].removeClass('hide');
                            }.bind(this), onComplete: function () {
                                this.currentStep = next;
                            }.bind(this) });
                    }.bind(this) });
            }
            else if (direction === 'previous') {
                TweenMax.to(window, 0.3, { scrollTo: { y: 200 }, ease: Power3.easeInOut, onComplete: function () {
                        // Animate wrapper height
                        TweenMax.to(this.dom.form.wrapper, this.duration.wrapper, { height: this.hSlide, ease: Power3.easeInOut });
                        // Set current timeline
                        this.dom.timelines[this.currentStep].removeClass('current');
                        this.dom.timelines[next].addClass('current');
                        // Animate passed Form
                        TweenMax.to(this.dom.form.slides[this.currentStep], this.duration.slides, { left: '100vw', ease: Power3.easeOut, onComplete: function () {
                                this.dom.form.slides[this.currentStep].addClass('hide');
                                this.dom.form.slides[this.currentStep].style.display = 'none';
                            }.bind(this) });
                        // Animate next form
                        TweenMax.fromTo(this.dom.form.slides[next], this.duration.slides, { left: '-100vw' }, { left: 0, ease: Power3.easeIn, onStart: function () {
                                this.dom.form.slides[next].style.display = 'block';
                                this.dom.form.slides[next].removeClass('hide');
                            }.bind(this), onComplete: function () {
                                this.currentStep = next;
                            }.bind(this) });
                    }.bind(this) });
            }
        };
        UI.prototype.buildResume = function (data) {
            var data = JSON.parse(data.project);
            var html = '';
            html += '<div class="row">';
            html += '<div class="info-type"><span class="text-1">Nom</span></div>';
            html += '<div class="info-value"><span class="text-1">' + data.lastname + '</span></div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="info-type"><span class="text-1">Prénom</span></div>';
            html += '<div class="info-value"><span class="text-1">' + data.firstname + '</span></div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="info-type"><span class="text-1">Email</span></div>';
            html += '<div class="info-value"><span class="text-1">' + data.email + '</span></div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="info-type"><span class="text-1">Code postal</span></div>';
            html += '<div class="info-value"><span class="text-1">' + data.zipcode + '</span></div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="info-type"><span class="text-1">Téléphone</span></div>';
            html += '<div class="info-value"><span class="text-1">' + data.phone + '</span></div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="info-type"><span class="text-1">Nom du projet</span></div>';
            html += '<div class="info-value"><span class="text-1">' + data.project + '</span></div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="info-type"><span class="text-1">Fond</span></div>';
            html += '<div class="info-value"><span class="text-1">' + data.funds + '</span></div>';
            html += '</div>';
            this.dom.resume.innerHTML = html;
            this.switchForm('next');
        };
        return UI;
    })();
    Subscribe.UI = UI;
})(Subscribe || (Subscribe = {}));
/// <reference path="generics/typed/gsap.d.ts" />
/// <reference path="generics/typed/Element.prototype.d.ts" />
var Kernel = (function () {
    function Kernel() {
        this.body = null;
        this.wrapper = null;
        this._class = null;
        this.body = document.querySelector('body');
        this.wrapper = this.body.querySelector('.main-wrapper');
        this.getCaller();
        this.init();
    }
    Kernel.prototype.init = function () {
        window.onload = this.show.bind(this);
    };
    Kernel.prototype.show = function () {
        this.body.addClass('site-loaded');
    };
    Kernel.prototype.getCaller = function () {
        this._class = this.wrapper.getAttribute('data-app-class');
        if (this._class !== null) {
            if (typeof window[this._class] !== 'undefined')
                new window[this._class].Core();
            else
                throw new Error('/!\\ Core::Kernel : page "' + this._class + '" does not exists. Please check if "' + this._class + '.module.ts" module exists ! /!\\');
        }
        else
            throw new Error('Kernel ::: data-app-class attribute doesn\'t exists on your .main-wrapper');
    };
    return Kernel;
})();
document.addEventListener('DOMContentLoaded', function () {
    new Kernel();
});