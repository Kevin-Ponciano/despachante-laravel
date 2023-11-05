$(document).ready(function () {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

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

        const relatorio_pedido = new WebDataRocks({
            container: "#relatorios-pedido-table",
            beforetoolbarcreated: customizeToolbar,
            toolbar: true,
            width: '100%',
            height: 720,
            customizeCell: customizeCellFunction,
        });

        function customizeToolbar(toolbar) {
            let tabs = toolbar.getTabs(); // get all tabs from the toolbar
            toolbar.getTabs = function () {
                tabs = tabs.filter(tab => tab.id !== "wdr-tab-connect")
                return tabs;
            }
        }

        function changeTitle(title) {
            relatorio_pedido.setOptions({
                grid: {
                    title: title
                }
            });
            relatorio_pedido.refresh();
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

                if (cellData.value === 0
                    && !cellData.measure?.uniqueName.includes("total_quantidade")
                    && !cellData.measure?.uniqueName.includes("total_preco")) {
                    cellBuilder.text = 'X'
                    cellBuilder.addClass('text-red')
                }
            }
            if (cellData.measure?.uniqueName === 'total_preco') {
                cellBuilder.classes.pop()
                cellBuilder.addClass('bg-success text-white')
            } else if (cellData.measure?.uniqueName === 'total_quantidade') {
                cellBuilder.addClass('bg-twitter text-white')
            }
        }

        function createOptions(title, type) {
            return {
                grid: {
                    title: title,
                    type: type,
                    showTotals: 'off',
                    showGrandTotals: 'on',
                    grandTotalsPosition: 'bottom',
                    showHeaders: false,
                    saveAllFormats: true,
                    //showFilter: false,
                }
            };
        }

        function createReportFilters() {
            return [
                {
                    uniqueName: "status",
                    filter: {
                        members: [
                            "status.Concluído",
                        ]
                    }
                }
            ];
        }

        function createMeasuresSomatorio(servicos) {
            let measures = [
                {
                    uniqueName: "total_preco_processo",
                    aggregation: "sum",
                    caption: "Preço Processo",
                    format: "pt_br",
                },
                {
                    uniqueName: "total_quantidade_processo",
                    aggregation: "sum",
                    caption: "Quantidade Processo"
                },
                {
                    uniqueName: "total_preco_placa",
                    aggregation: "sum",
                    caption: "Preço Placa",
                    format: "pt_br",
                },
                {
                    uniqueName: "total_quantidade_placa",
                    aggregation: "sum",
                    caption: "Quantidade Placa"
                },
                {
                    uniqueName: "total_preco_atpv",
                    aggregation: "sum",
                    caption: "Preço ATPV",
                    format: "pt_br",
                },
                {
                    uniqueName: "total_quantidade_atpv",
                    aggregation: "sum",
                    caption: "Quantidade ATPV"
                },
                {
                    uniqueName: "total_preco_renave_entrada",
                    aggregation: "sum",
                    caption: "Preço RENAVE Entrada",
                    format: "pt_br",
                },
                {
                    uniqueName: "total_quantidade_renave_entrada",
                    aggregation: "sum",
                    caption: "Quantidade RENAVE Entrada"
                },
                {
                    uniqueName: "total_preco_renave_saida",
                    aggregation: "sum",
                    caption: "Preço RENAVE Saída",
                    format: "pt_br",
                },
                {
                    uniqueName: "total_quantidade_renave_saida",
                    aggregation: "sum",
                    caption: "Quantidade RENAVE Saída"
                }
            ];
            servicos.forEach(servico => {
                measures.push({
                    uniqueName: 'total_preco_' + servico,
                    aggregation: "sum",
                    caption: "Preço: " + servico,
                    format: "pt_br",
                });
                measures.push({
                    uniqueName: 'total_quantidade_' + servico,
                    aggregation: "sum",
                    caption: "Quantidade: " + servico
                });
            });
            measures.push(
                {
                    uniqueName: "total_preco",
                    formula: createTotalPrecoFormula(servicos),
                    caption: "Total Preço",
                    format: "pt_br",
                },
                {
                    uniqueName: "total_quantidade",
                    formula: createTotalQuantidadeFormula(servicos),
                    caption: "Total Quantidade",
                    format: "",
                }
            );
            return measures;
        }


        function createColumns(servicos) {
            return [
                {uniqueName: "numero_pedido", caption: "Nº Pedido", sort: "asc", filter: {}},
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
            ];
        }

        function createMeasures(servicos) {
            return [
                {uniqueName: "honorario", aggregation: "sum", format: "pt_br"},
                {uniqueName: "numero_pedido", aggregation: "count"},
                {uniqueName: "valor_placas", aggregation: "sum", format: "pt_br"},
                ...servicos.map(servico => ({
                    uniqueName: servico,
                    aggregation: "sum",
                    format: "pt_br"
                })),
                ...createTotalFormula(servicos),
            ];
        }

        function createSorting(measures, type = 'asc') {
            return {
                column: {
                    type: type,
                    tuple: [],
                    measure: measures,
                }
            };
        }

        function createSlice(servicos) {
            return {
                reportFilters: createReportFilters(),
                rows: [],
                columns: createColumns(servicos),
                measures: createMeasures(servicos),
                sorting: createSorting('numero_pedido'),
            };
        }

        function createSliceSomatorio(servicos) {
            return {
                rows: [
                    {
                        uniqueName: "Measures"
                    }
                ],
                columns: [
                    {
                        uniqueName: "nomeCliente",
                        caption: "Cliente",
                        expand: true,
                    }
                ],
                measures: createMeasuresSomatorio(servicos),
                sorting: createSorting('nomeCliente'),
            };

        }

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

        function createTotalPrecoFormula(servicos) {
            let formula = "sum('total_preco_processo') + sum('total_preco_placa') + sum('total_preco_atpv') + " +
                "sum('total_preco_renave_entrada') + sum('total_preco_renave_saida')";
            const servicoPrecoFormulas = servicos.map(servico => `sum('total_preco_${servico}')`).join(' + ');
            if (servicoPrecoFormulas) {
                formula += ' + ' + servicoPrecoFormulas;
            }
            return formula;
        }

        function createTotalQuantidadeFormula(servicos) {
            let formula = "sum('total_quantidade_processo') + sum('total_quantidade_placa') + sum('total_quantidade_atpv') + " +
                "sum('total_quantidade_renave_entrada') + sum('total_quantidade_renave_saida')";
            const servicoQuantidadeFormulas = servicos.map(servico => `sum('total_quantidade_${servico}')`).join(' + ');
            if (servicoQuantidadeFormulas) {
                formula += ' + ' + servicoQuantidadeFormulas;
            }
            return formula;
        }


        function createFormats() {
            return [
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
            ];
        }

        function createReportConfig(servicos) {
            return {
                options: createOptions('Relatório de Pedidos', 'flat'),
                slice: createSlice(servicos),
                formats: createFormats(),
            };
        }

        function createReportConfigSomatorio(servicos) {
            return {
                options: createOptions('Relatório de Pedidos - Somatório', 'compact'),
                slice: createSliceSomatorio(servicos),
                formats: createFormats(),
            };
        }

        function setReport(data, type = 'geral') {
            let reportConfigs;
            switch (type) {
                case 'geral':
                    reportConfigs = createReportConfig(data.servicos);
                    break;
                case 'somatorio':
                    reportConfigs = createReportConfigSomatorio(data.servicos);
                    break;
            }
            const report = {
                dataSource: {
                    dataSourceType: 'json',
                    data: data.report,
                },
                ...reportConfigs,
                localization: '/assets/js/WebDataRocks.translate.json',
            }
            relatorio_pedido.setReport(report);
        }

        function createReport() {
            $.ajax({
                url: '/despachante/relatorios/pedidos/geral',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    ...getDates(),
                },
                success: function (data) {
                    setReport(data);
                },
                error: function (data) {
                }
            })
        }

        function createReportSomatorio() {
            if (!isValidFilters(getFilters())) {
                Livewire.emit('warning', 'Filtros inválidos para o relatório de somatório<br>' +
                    'Os filtros válidos são: <b>Cliente, Status e Tipo</b>');
                return;
            }

            $.ajax({
                url: '/despachante/relatorios/pedidos/total',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    ...getDates(),
                    filters: prepareFilter(),
                },
                success: function (data) {
                    setReport(data, 'somatorio');
                },
                error: function (data) {
                }
            })
        }

        function prepareFilter() {
            let filters = getFilters();
            return filters.map(filter => {
                return {
                    'column': filter.uniqueName, // This assumes that uniqueName is already properly formatted.
                    'fields': filter.filter.members.map(member => {
                        const dotIndex = member.indexOf('.'); // Find the index of the first dot.
                        return dotIndex !== -1 ? member.substring(dotIndex + 1) : member; // Get the substring after the dot.
                    }),
                    'isNegation': filter.filter.negation ?? false,
                }
            });
        }

        function isValidFilters(filters) {
            if (filters.length === 0) return true;
            let isValid = true;
            filters.forEach(filter => {
                if (filter.uniqueName !== 'cliente' && filter.uniqueName !== 'status' && filter.uniqueName !== 'tipo') {
                    isValid = false;
                }
            })
            return isValid;
        }

        function getFilters() {
            return relatorio_pedido.getReport().slice.columns.filter(column => column.filter != null);
        }

        function getDates() {
            const start_date = $('#start_date').val();
            const end_date = $('#end_date').val();
            if (!start_date || !end_date) {
                Livewire.emit('warning', 'Selecione as datas de início e fim');
                return;
            }
            return {
                start_date: start_date,
                end_date: end_date,
            }
        }

        $('#setDateReport').on('click', function () {
            if (!getDates()) return;
            createReport();
            $('#somatorio').prop('disabled', false);
        })

        $('#somatorio').on('click', function () {
            if (!getDates()) return;
            createReportSomatorio();
        })

        relatorio_pedido.on('reportcomplete', function () {
            $('#loading-overlay').hide();
        });

        relatorio_pedido.on('dataloaded', function () {
            $('#loading-overlay').show();
        });

        relatorio_pedido.on('update', function () {
            if (!isValidFilters(getFilters())) {
                const btn = $('#somatorio');
                btn.prop('disabled', true);
                btn.addClass('disabled');
                const parent = btn.parent();
                parent.attr('data-bs-original-title', 'Filtros inválidos para o relatório de somatório. Os filtros válidos são: STATUS, CLIENTE e TIPO');
            } else {
                const btn = $('#somatorio');
                btn.prop('disabled', false);
                btn.removeClass('disabled');
                const parent = btn.parent();
                parent.attr('data-bs-original-title', 'Gerar um relatório com a soma dos valores');
            }
        });
    }
)

