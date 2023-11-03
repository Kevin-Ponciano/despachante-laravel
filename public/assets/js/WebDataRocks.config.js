$(document).on('livewire:load', function () {
    const pivot = new WebDataRocks({
        container: "#relatorios-pedido-table",
        beforetoolbarcreated: customizeToolbar,
        toolbar: true,
        width: '100%',
        height: 700,
        customizeCell: customizeCellFunction,
    });

    function customizeToolbar(toolbar) {
        let tabs = toolbar.getTabs(); // get all tabs from the toolbar
        toolbar.getTabs = function () {
            delete tabs[0]; // delete the first tab
            //delete tabs[1]; // delete the second tab
            //delete tabs[2]; // delete the third tab
            return tabs;
        }
    }

    function formatDate(dateString) {
        let parts = dateString.split('-');

        let day = parts[2];
        let month = parts[1];
        let year = `20${parts[0]}`

        return `${day}/${month}/${year}`;
    }


    function customizeCellFunction(cellBuilder, cellData) {
        //console.log(cellData)
        if (cellData.type === "value") {
            const label = cellData.label

            if (cellData.rowIndex % 2 === 0) {
                cellBuilder.addClass("bg-gray-900");
            }

            if (cellData.hierarchy?.uniqueName === 'criado_em' && cellData.value) {
                cellBuilder.text = formatDate(label)
            } else if (cellData.hierarchy?.uniqueName === 'concluido_em' && cellData.value && label !== 'Não concluído') {
                cellBuilder.text = formatDate(label)
            }

            if (label === 'Aberto' || label === 'Concluído') {
                cellBuilder.addClass('text-success fw-bold')
            } else if (label === 'Em Andamento') {
                cellBuilder.addClass('text-primary fw-bold')
            } else if (label === 'Solicitado Cancelamento' || label === 'Retorno de Pendência' || label === 'Pendente') {
                cellBuilder.addClass('text-warning fw-bold')
            }

            if (cellData.value === 0) {
                cellBuilder.text = 'X'
                cellBuilder.addClass('text-red')
            }
        }
    }

    function createReportConfig(servicos) {
        function createTotalFormula(servicos) {
            const servicoFormulas = servicos.map(servico => `sum('${servico}')`).join(' + ');
            const totalFormula = `${servicoFormulas} + sum('honorario') + sum('valor_placas')`;
            return [{
                uniqueName: "Total",
                formula: totalFormula,
                caption: "Total",
                format: "pt_br",
            }];
        }

        return {
            options: {
                grid: {
                    title: 'Relatório de Pedidos',
                    type: 'flat',
                    showTotals: 'off',
                    showGrandTotals: 'on',
                    grandTotalsPosition: 'bottom',
                    showHeaders: false,
                    saveAllFormats: true,
                }
            },
            slice: {
                reportFilters: [
                    {
                        uniqueName: "status",
                        filter: {
                            members: [
                                "status.Concluído",
                            ]
                        }
                    }
                ],
                rows: [],
                columns: [
                    {uniqueName: "numero_pedido", caption: "Nº Pedido", sort: "asc"},
                    {uniqueName: "status", caption: "Status"},
                    {uniqueName: "criado_em", caption: "Criado em"},
                    {uniqueName: "concluido_em", caption: "Concluído em"},
                    {uniqueName: "cliente"},
                    {uniqueName: "comprador_nome", caption: "Comprador"},
                    {uniqueName: "placa"},
                    {uniqueName: "valor_placas", caption: "Valor Placa"},
                    {uniqueName: "veiculo", caption: "Veículo"},
                    {uniqueName: "tipo"},
                    {uniqueName: "honorario", caption: "Honorário"},
                    ...servicos.map(servico => ({uniqueName: servico})),
                ],
                measures: [
                    {uniqueName: "honorario", aggregation: "sum", format: "pt_br"},
                    {uniqueName: "numero_pedido", aggregation: "count"},
                    {uniqueName: "valor_placas", aggregation: "sum", format: "pt_br"},
                    ...servicos.map(servico => ({
                        uniqueName: servico,
                        aggregation: "sum",
                        format: "pt_br"
                    })),
                    ...createTotalFormula(servicos),
                ],
                sorting: {
                    column: {
                        type: "asc",
                        tuple: [],
                        measure: 'numero_pedido'
                    }
                }
            },
            formats: [
                {
                    name: "pt_br",
                    thousandsSeparator: ".",
                    decimalSeparator: ",",
                    decimalPlaces: 2,
                    maxSymbols: 20,
                    currencySymbol: "R$ ",
                    currencySymbolAlign: "left",
                    nullValue: "",
                    infinityValue: "",
                    divideByZeroValue: "",
                }
            ],
            localization: '/assets/js/WebDataRocks.translate.json',
        };
    }

    function setReport(data) {
        const report = {
            dataSource: {
                dataSourceType: 'json',
                data: data.report,
            },
            ...createReportConfig(data.servicos)
        }
        pivot.setReport(report);
    }

    function createReport(dates) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Obter o token CSRF
        $.ajax({
            url: '/despachante/relatorios/pedidos/table',
            type: 'POST',
            data: {
                _token: csrfToken,
                ...dates,
            },
            success: function (data) {
                setReport(data);
            },
            error: function (data) {
                console.log(data)
            }
        })
    }

    $('#setDateReport').on('click', function () {
        const dates = {
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
        }
        createReport(dates);
        pivot.refresh()
    })

    createReport()

    function setTheme(cssUrl) {
        let prevThemeTags = getPrevTheme();
        let link = document.createElement('link');
        link.href = cssUrl;
        link.rel = "stylesheet";
        link.type = "text/css";
        link["onload"] = function () {
            if (prevThemeTags != null) {
                for (let i = 0; i < prevThemeTags.length; i++) {
                    if (window.ActiveXObject || "ActiveXObject" in window) {
                        prevThemeTags[i].removeNode(true);
                    } else {
                        prevThemeTags[i].remove();
                    }
                }
            }
        };
        document.body.appendChild(link);
    }

    function getPrevTheme() {
        let linkTags = document.head.getElementsByTagName("link");
        let prevThemeTags = [];
        for (let i = 0; i < linkTags.length; i++) {
            if (linkTags[i].href.indexOf("webdatarocks.min.css") > -1 || linkTags[i].href.indexOf("webdatarocks.css") > -1) {
                prevThemeTags.push(linkTags[i]);
            }
        }
        linkTags = document.body.getElementsByTagName("link");
        for (let i = 0; i < linkTags.length; i++) {
            if (linkTags[i].href.indexOf("webdatarocks.min.css") > -1 || linkTags[i].href.indexOf("webdatarocks.css") > -1) {
                prevThemeTags.push(linkTags[i]);
            }
        }
        return prevThemeTags;
    }

    $('.hide-theme-dark').on('click', function () {
        setTheme('https://cdn.webdatarocks.com/latest/theme/dark/webdatarocks.min.css');
    })
    $('.hide-theme-light').on('click', function () {
        setTheme('https://cdn.webdatarocks.com/latest/theme/lightblue/webdatarocks.min.css')
    })

    let selectedTheme = localStorage.getItem('theme');
    if (selectedTheme === 'dark') {
        setTheme('https://cdn.webdatarocks.com/latest/theme/dark/webdatarocks.min.css');
    } else {
        setTheme('https://cdn.webdatarocks.com/latest/theme/lightblue/webdatarocks.min.css')
    }
});
