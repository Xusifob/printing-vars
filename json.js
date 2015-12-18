app.directive('json',function () {
    return {
        restrict: 'E',
        template: function() {

            // Some style vars
            var height = '450px';
            var background = '#4dba9d';

            // Here you can add style
            var style = 'json .panel-group {' +
                'position: fixed;' +
                'bottom: 0;' +
                'left: 0;' +
                'right: 0;' +
                'margin-bottom: 0;' +
                'z-index: 9; }' +
                'json .panel-group .panel-heading {' +
                'padding: 0; ' +
                'background-color : '+ background +';' +
                'color:#fff;}' +
                'json .panel-group .panel-title a {' +
                'width: 100%;' +
                'display: block;' +
                'padding: 10px;' +
                'color #fff }' +
                'json .panel-group .panel-body {' +
                'max-height: '+ height +';' +
                'overflow-y: scroll; }';

            return '<style>' +style + '</style>'+
                '<accordion class="mg-top-25">' +
                '<accordion-group heading="JSON">' +
                '<pre>{{value | json}}</pre>' +
                '</accordion-group>' +
                '</accordion>';
        },
        scope: {
            value: '='
        }
    };
});