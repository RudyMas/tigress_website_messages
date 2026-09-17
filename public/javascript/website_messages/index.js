document.addEventListener('DOMContentLoaded', function () {
    window.tigress = window.tigress || {};

    window.tigress.loadTranslations(language.translations).then(function () {

        let url = '/website-messages/get-data/active';
        if (variables.show) {
            url = '/website-messages/get-data/inactive';
        }

        new DataTable('#dataTableWebsiteMessages', {
            processing: true,
            stateSave: true,
            ajax: {
                url: url,
                dataType: 'json'
            },
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'Alle']
            ],
            responsive: true,
            scrollX: true,
            columns: [
                {
                    title: 'ID',
                    data: 'id',
                    className: 'text-middle',
                    width: '1%'
                },
                {
                    title: __('Page URL'),
                    data: 'url_location',
                    className: 'text-nowrap text-middle',
                    width: '1%'
                },
                {
                    title: __('Title'),
                    data: 'title',
                    className: 'text-middle',
                    width: '99%'
                },
                {
                    title: __('Type'),
                    data: 'type',
                    className: 'text-middle',
                    width: '1%'
                },
                {
                    title: __('Display'),
                    data: 'display',
                    className: 'text-middle',
                    width: '1%'
                },
                {
                    title: __('From'),
                    data: 'active_from',
                    className: 'text-nowrap text-center text-middle',
                    width: '1%',
                    render: function (data, type, row) {
                        if (!data) return '';

                        if (type === 'display' || type === 'filter') {
                            return moment(data, 'YYYY-MM-DD HH:mm:ss').format('DD-MM-YYYY HH:mm');
                        }

                        return moment(data, 'YYYY-MM-DD HH:mm:ss').valueOf();
                    }
                },
                {
                    title: __('Until'),
                    data: 'active_until',
                    className: 'text-nowrap text-center text-middle',
                    width: '1%',
                    render: function (data, type, row) {
                        if (!data) return '';

                        if (type === 'display' || type === 'filter') {
                            return moment(data, 'YYYY-MM-DD HH:mm:ss').format('DD-MM-YYYY HH:mm');
                        }

                        return moment(data, 'YYYY-MM-DD HH:mm:ss').valueOf();
                    }
                },
                {
                    title: __('Actions'),
                    data: null,
                    className: 'text-nowrap text-end text-middle',
                    width: '1%',
                    render: function (data, type, row) {
                        let output = '';
                        if (variables.write && row.active === 1) {
                            output += `
                            <a href="/website-messages/edit/${row.id}" class="btn btn-sm btn-success" data-toggle="tooltip" title="${__('Edit')}">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                        `;
                        }
                        if (variables.delete) {
                            if (row.active === 1) {
                                output += `
                                <button class="btn btn-sm btn-danger index-archive-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#confirmArchiveWebsiteMessageModal" title="${__('Archiving')}">
                                    <i class="fa-solid fa-archive"></i>
                                </button>
                            `;
                            } else {
                                output += `
                                <button class="btn btn-sm btn-success index-restore-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#confirmRestoreWebsiteMessageModal" title="${__('Restoring')}">
                                    <i class="fa-solid fa-recycle"></i>
                                </button>
                            `;
                            }
                            if (row.active === 0) {
                                output += `
                                <button class="btn btn-sm btn-danger index-delete-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#confirmDeleteWebsiteMessageModal" title="${__('Deleting')}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            `;
                            }
                        }
                        return output.trim();
                    }
                }
            ],
            order: [[0, 'desc']],
            language: tigress.languageDatatables,
            drawCallback: function () {
                initTooltips();
            }
        })
    });

    document.addEventListener('click', (e) => {
        const deleteBtn = e.target.closest('.index-delete-btn');
        if (deleteBtn) {
            e.preventDefault();
            const id = deleteBtn.dataset.id;
            document.getElementById('confirmDeleteWebsiteMessageBtn').href = `/website-messages/delete/${id}`;
        }

        const archiveBtn = e.target.closest('.index-archive-btn');
        if (archiveBtn) {
            e.preventDefault();
            const id = archiveBtn.dataset.id;
            document.getElementById('confirmArchiveWebsiteMessageBtn').href = `/website-messages/archive/${id}`;
        }

        const restoreBtn = e.target.closest('.index-restore-btn');
        if (restoreBtn) {
            e.preventDefault();
            const id = restoreBtn.dataset.id;
            document.getElementById('confirmRestoreWebsiteMessageBtn').href = `/website-messages/restore/${id}`;
        }
    });
});