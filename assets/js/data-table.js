var DataTable = (function () {
    function DataTable(data, options) {
        this._defaultOptions = {};
    }

    DataTable.prototype.generate = function () {
        this.table = $('<table/>');
        var header = $('<thead/>').appendTo(this.table);
        var headerLine = $('<tr/>').appendTo(header);
        $('<tbody/>').appendTo(this.table);
        for (var columnId in this.columns) {
            var cellValue = this.columns[columnId];
            var attributes = '';
            if (typeof cellValue === 'object') {
                var label = this.columns[columnId].label;
                for (var attribute in cellValue) {
                    if (attribute != 'label') {
                        attributes += ' ' + attribute + '="' + cellValue[attribute] + '"';
                    }
                }
            } else {
                var label = this.columns[columnId];
            }
            if (attributes.indexOf('id=') == -1) {
                attributes += ' id="' + columnId + '"';
            }
            $('<th ' + attributes + '>' + label + '</th>').appendTo(headerLine);
        }
        this.element.html(this.table);
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
