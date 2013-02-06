var DataTable = (function () {
    
    /**
    * TODO:
    * - data object|url
    * - jQueryUI reorder
    */
    
    function DataTable(data, options) {
        if (typeof data !== 'object') {
            throw new Error('DataTable: Specified data is not a valid object.');
        }
        this._data = data;

        this._defaultOptions = {
            container: null,
            headers: [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ],
            squareClass: 'square',
            squareHeaderClass: 'squareHeader',
            onReorder: null
        };
        this._requiredOptions = {
            container: 'Container element was not specified.'
        };
        this._options = {};
        
        for (var option in this._defaultOptions) {
            if (options.hasOwnProperty(option)) {
                this._options[option] = options[option];
            } else if (this._requiredOptions.hasOwnProperty(option)) {
                throw new Error('DataTable: ' + this._requiredOptions[option]);
            } else {
                this._options[option] = this._defaultOptions[option];
            }
        }
        
        this._container = this._options['container'];
        
        this._today = (new Date()).toLocaleDateString();
        
        this._generateGrid();
    }
    
    DataTable.prototype._generateGrid = function () {
        this._container.html('');
        this._setContainerWidth(7);
        
        for (var head in this._options.headers) {
            this._squareHead(this._options.headers[head]).appendTo(this._container);
        }
        
        var dayOfWeek = 1;
        for (var idx in this._data) {
            var dataPiece = this._data[idx];
            var dataDOW = (new Date(dataPiece.date)).getDay();
            if (dataDOW!==dayOfWeek) {
                if (dataDOW>1) {
                    for (var i=dayOfWeek; i<(dataDOW); i++) {
                        this._square().appendTo(this._container);
                    }
                }
                dayOfWeek = dataDOW;
            }
            this._square(dataPiece).appendTo(this._container);
            if (dayOfWeek==5) {
                this._square().appendTo(this._container); 
                this._square().appendTo(this._container);
                dayOfWeek = 0;
            }
            dayOfWeek++;
        }
        if (dayOfWeek > 1) {
            for (var i=dayOfWeek; i<=7; i++) {
                this._square().appendTo(this._container);
            }
        }
    };

    DataTable.prototype._setContainerWidth = function (widthMultiplier) {
        var square = $('<div/>').addClass(this._options.squareClass).css({visibility: 'hidden'});
        square.appendTo('body');
        var squareWidth = square.outerWidth(true);
        square.remove();
        this._container.width(squareWidth*widthMultiplier);
    };
        
    DataTable.prototype._square = function (data) {
        var mySquare = $('<div/>').addClass(this._options['squareClass']);
        if (data!==undefined) {
            var myDate = new Date(data.date);
            var dateString = myDate.toJSON();
            mySquare.attr('id', dateString);
            mySquare.html(this.toHtml(data));
            if (myDate.toLocaleDateString() == this._today) {
                mySquare.addClass('today');
            }
        } else {
            mySquare.addClass('disabled').html('empty');
        }
        
        return mySquare;
    };
    
    DataTable.prototype._squareHead = function (label) {
        var mySquare = $('<div/>').addClass(this._options['squareHeaderClass']);
        if (label!==undefined) {
            mySquare.html(label);
        } else {
            mySquare.addClass('disabled');
        }
        return mySquare;
    };
    
    DataTable.prototype.toHtml = function (data) {
        return data.assignee;
    };
    
    DataTable.prototype.fill = function (data) {
        var x = 0, y = 0;
        var tBody = this.table.children('tbody');
        tBody.empty();
        for (var i = 0; i < Object.keys(data).length; i++) {
            var tableLine = $('<tr/>').appendTo(tBody);
            for (var j = 0; j < Object.keys(this.columns).length; j++) {
                $('<td id="' + this.prefix + i + '-' + j + '"></td>').appendTo(tableLine);
            }
        }

        for (var line in data) {
            for (var column in data[line]) {
                var content = data[line][column];
                var element = $('#' + this.prefix + x + '-' + y);
                var htmlContent = content;
                if (typeof content === 'object') {
                    htmlContent = content.html;
                    for (var attribute in content) {
                        if (attribute != 'html') {
                            element.attr(attribute, content[attribute]);
                        }
                    }
                }
                this.data[ x + '-' + y]=element;
                element.html(htmlContent);
                y++;
            }
            x++;
            y = 0;
        }
    };

    DataTable.prototype.hilight = function(x, y) {
        if (/^\d+$/.test(x)) {
            this.data[ x + '-' + y].addClass('highlight');
        } else {
            this.table.find('td:contains('+x+')').addClass('highlight');
        }
    };

    return DataTable;
})();
