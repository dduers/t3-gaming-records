(function () {

    let settings = {
        full: {
            responsive: true,
            order: [],
            layout: {
                topStart: 'info',
                topEnd: {
                    search: {
                        text: '_INPUT_',
                        placeholder: 'Search',
                    },
                },
                top1: {
                    searchPanes: {
                        cascadePanes: true,
                        initCollapsed: true,
                    },
                },
                bottomStart: {
                    paging: {
                        type: 'simple_numbers',
                    },
                },
                bottomEnd: {
                    buttons: {
                        buttons: ['copy', 'csv', 'excel'],
                    },
                },
            },
            language: {
                searchPanes: {
                    emptyPanes: ''
                },
            },
        },
        basic: {
            responsive: true,
            order: [],
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            lengthChange: false,
        },

        // for record data table
        record: {
            columnDefs: [
                {
                    // right align time
                    targets: [4, 5, 6],
                    className: 'dt-body-right dt-head-left',
                    searchPanes: {
                        show: false
                    },
                },
            ],
        },

        // for game data table
        game: {
            columnDefs: [
                {
                    // right align time
                    targets: [3],
                    className: 'dt-body-right dt-head-left',
                    searchPanes: {
                        show: false
                    },
                },
            ],
        },

        // for player table data
        player: {
            columnDefs: [
                {
                    // right align time
                    targets: [6],
                    className: 'dt-body-right dt-head-left',
                    searchPanes: {
                        show: false
                    },
                },
            ],
        },
    }

    let table_record = new DataTable('.t3gamingrecords-table-record', Object.assign({}, settings.full, settings.record));
    let table_game = new DataTable('.t3gamingrecords-table-game', Object.assign({}, settings.full, settings.game));
    let table_player = new DataTable('.t3gamingrecords-table-player', Object.assign({}, settings.full, settings.player));
})();
