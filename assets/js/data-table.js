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
        this._swapEnabled = false;
        
        this._generateGrid();
        this.enableSwap();
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
            var dateString = myDate.valueOf();
            mySquare.attr('id', dateString);
            mySquare.attr('assignee', data.assignee);
            mySquare.html(this._dataElementToHtml(data));
            if (myDate.toLocaleDateString() == this._today) {
                mySquare.addClass('today');
            }
        } else {
            var previousElement = this._container.children('.square:last');
            if (previousElement.length>0 && previousElement.attr('id')) {
                var myDate = new Date();
                myDate.setTime(previousElement.attr('id'));
                myDate.setDate(myDate.getDate()+1);
                mySquare.attr('id', myDate.valueOf());
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
    
    DataTable.prototype._dataElementToHtml = function (data) {
        return data.assignee;
    };
    
    DataTable.prototype.enableSwap = function() {
        var $this = this;
        $('div.'+this._options.squareClass+':not(.disabled)')
        .draggable({ 
            revert: true,
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
            },
            drop: function(event, ui) {
                $this._swapSquares($(this), ui.draggable);
                $(this).effect('pulsate', {times: 3});
            }
        });
        this._swapEnabled = true;
    };
    
    DataTable.prototype.disableSwap = function() {
        $('div.'+this._options.squareClass+':not(.disabled)').draggable('disable').droppable('disable');
        this._swapEnabled = false;
    };
    
    DataTable.prototype._swapSquares = function(squareOne, squareTwo) {
        var assignee = squareOne.attr('assignee');
        var label = squareOne.contents().get(0);
        var dateblock = $(squareOne.contents()[1]);
        var dateblockTwo = $(squareTwo.contents()[1]);
        squareOne.attr('assignee', squareTwo.attr('assignee'));
        squareOne.html($(squareTwo.contents().get(0)));
        dateblock.appendTo(squareOne);
        squareTwo.attr('assignee', assignee);
        squareTwo.html($(label));
        dateblockTwo.appendTo(squareTwo);
        
    };
    
    
    DataTable.prototype.toJSON = function() {
        return this._container.find('.square:not(.disabled)')
            .map(function(index, domElement){ 
                var x={}; 
                var  myDate = new Date();
                myDate.setTime($(domElement).attr('id'));
                x.date=myDate.getFullYear()+'-'+myDate.getMonth()+'-'+myDate.getDate(); 
                x.assignee=$(domElement).attr('assignee'); 
                return x;
            });
    };
    
    DataTable.prototype.toString = function() {
        var jsonArray = this.toJSON();
        var textResult = [];
        for (var i=0; i<jsonArray.length; i++) {
            textResult.push(jsonArray[i].date+': '+jsonArray[i].assignee);
        }
        return textResult.join(', ');
    };
    
    return DataTable;
})();
