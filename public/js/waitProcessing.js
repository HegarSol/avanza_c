var app;
app = app || (function () {
    //var process = $('<div id="process" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false"><div class="modal-header"><h3>Processing...</h3></div><div class="modal-body"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div></div>');
    var process = $('<div id="process" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h3>Procesando...</h3></div><div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 100%;"></div></div></div></div></div></div>');
    return {
        showProcess: function () {
            process.modal('show');
        },
        hideProcess: function () {
            process.modal('hide');
        }

    };
})();