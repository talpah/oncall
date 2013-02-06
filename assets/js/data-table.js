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
            skipWeekends: true,
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
        
        this._container = this._options.container;
        
        this._today = (new Date()).toLocaleDateString();
        this._sortEnabled = false;
        
        this._generateGrid();
        this.enableSort();
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
            if (this._options.skipWeekends && dayOfWeek==5) {
                this._square().appendTo(this._container); 
                this._square().appendTo(this._container);
                dayOfWeek = 0;
            }
            dayOfWeek++;
        }
        if (dayOfWeek > 1) {
            for (var d=dayOfWeek; d<=7; d++) {
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
        var mySquare = $('<div/>').addClass(this._options.squareClass);
        if (data!==undefined) {
            var myDate = new Date(data.date);
            var dateString = myDate.toJSON();
            mySquare.attr('id', dateString);
            mySquare.attr('assignee', data.assignee);
            mySquare.html(this.toHtml(data));
            if (myDate.toLocaleDateString() == this._today) {
                mySquare.addClass('today');
            }
        } else {
            var previousElement = this._container.children('.square:last');
            if (previousElement.length>0 && previousElement.attr('id')) {
                var myDate = new Date(previousElement.attr('id'));
                myDate.setDate(myDate.getDate()+1);
                mySquare.attr('id', myDate.toJSON());
            }
            mySquare.addClass('disabled').html('empty');
        }
        
        if (myDate) {
            $('<span/>').addClass('squareDate').html(myDate.getDate()).appendTo(mySquare);
        }
        
        return mySquare;
    };
    
    DataTable.prototype._squareHead = function (label) {
        var mySquare = $('<div/>').addClass(this._options.squareHeaderClass);
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
    
    DataTable.prototype.enableSort = function() {
        $('div.'+this._options.squareClass+':not(.disabled)')
        .draggable({ 
            revert: "invalid",
            stack: '.square',
            start: function(event, ui) {
                $('div[assignee="'+$(this).attr('assignee')+'"]').addClass('invalidTarget');
            },
            stop: function(event, ui) {
                $('.invalidTarget').removeClass('invalidTarget');
            }
        })
        .droppable({
            hoverClass: "hoversquare",
            accept: function(draggableElement) {
                return $(this).attr('assignee')!=$(draggableElement).attr('assignee');
            }
        });
        this._sortEnabled = true;
    };
    
    DataTable.prototype.disableSort = function() {
        $('div.'+this._options.squareClass+':not(.disabled)').draggable('disable').droppable('disable');
        this._sortEnabled = false;
    };
    
    
    return DataTable;
})();
