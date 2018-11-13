// configuration for jshint
/* jshint browser: true, devel: true, multistr:true */
/* global Vue, get, post, $, EventBus */

"use strict";

Vue.component('invoice-table', {
    props: ['endpoint', 'title', 'description', 'button', 'action', 'home'],
    data: function() {
        return {
            invoices: []
        };
    },
    mounted: function() {
        this.loadData();
    },
    created: function() {
        var self = this;
        EventBus.$on('refreshTables', function() {
            self.loadData();
        });
    },
    methods: {
        doit: function() {
            post(this.home + this.action);
        },
        loadData: function() {
            var self = this;
            var request = new XMLHttpRequest();
            request.open("GET", self.home + self.endpoint);
            request.onload = function() {
                if (request.status == 200) {
                    if (request.responseText) {
                        var data = JSON.parse(request.responseText);
                        self.invoices = data.invoices;
                    }
                }
            };
            request.send();
        }
    },
    template: '\
<div class="card mb-3">\
    <div class="card-header">\
        <i class="fas fa-table"></i> {{ title }}\
    </div>\
    <div class="card-body">\
        <div class="table-responsive">\
            <div>\
                <table class="table table-bordered" width="100%" cellspacing="0">\
                    <thead>\
                        <tr>\
                            <th>Id</th>\
                            <th>Nome file</th>\
                            <th>Data e ora</th>\
                        </tr>\
                    </thead>\
                    <tbody>\
                        <tr v-for="i in invoices">\
                            <td>{{ i.id }}</td>\
                            <td>{{ i.nomefile }}</td>\
                            <td>{{ i.ctime }}</td>\
                        </tr>\
                    </tbody>\
                </table>\
            </div>\
        </div>\
    </div>\
    <div class="card-footer small text-muted">\
        <span class="text-muted">{{ description }}</span>\
        <button style="float: right;" v-if="button" type="button" v-on:click="doit();" class="btn btn-info">{{ button }}</button>\
    </div>\
</div>'
});

// Show filename, show clear button and change browse 
//button text when a valid extension file is selected
$(".browse-button input:file").change(function() {
    $("input[name='attachment']").each(function() {
        var fileName = $(this).val().split('/').pop().split('\\').pop();
        $(".filename").val(fileName);
        $(".browse-button-text").html('<i class="fa fa-refresh"></i> Change');
        $(".clear-button").show();
    });
});

//actions happening when the button is clicked
$('.clear-button').click(function() {
    $('.filename').val("");
    $('.clear-button').hide();
    $('.browse-button input:file').val("");
    $(".browse-button-text").html('<i class="fa fa-folder-open"></i> Browse');
});