import React, { Component } from "react";
import ReactDOM from "react-dom";
const axios = require("axios");
import ReactTable from "react-table";
import "react-table/react-table.css";
import matchSorter from "match-sorter";

export default class Example extends Component {
    constructor(props) {
        super(props);
        this.state = { gitRepo: "", dateStart: "", dateEnd: "" };
    }
    /**
     * input обработчик
     */
    handleChange = e => {
        this.setState({ [e.target.name]: event.target.value });
    };
    /**
     * Обработчик отправки формы
     */
    handleSubmit = event => {
        event.preventDefault();
        let self = this;
        axios
            .post("./api/getFiles", this.state)
            .then(function(response) {
                if (response.data.error) {
                    self.setState({ error: response.data.error });
                } else {
                    self.setState({ listFiles: response.data });
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    };

    render() {
        /**
         * Данные для таблицы
         */
        let data = [];
        if (this.state.listFiles) {
            let oldArray = this.state.listFiles;
            Object.keys(oldArray).map(function(keyName, keyIndex) {
                let totalChange = oldArray[keyName].totalCommitChange;
                let authors = oldArray[keyName].authors;
                data.push({
                    filename: keyName,
                    totalChange: totalChange,
                    authors: authors
                });
            });
        }

        /**
         * Настройки для таблицы
         */
        const columns = [
            {
                Header: "Название файла",
                accessor: "filename",
                filterMethod: (filter, rows) =>
                    matchSorter(rows, filter.value, {
                        keys: ["filename"]
                    }),
                filterAll: true
            },
            {
                Header: "Общее кол-во коммитов",
                accessor: "totalChange",
                filterMethod: (filter, row) =>
                    String(row[filter.id]) === filter.value
            },
            {
                id: "authors",
                Header: "Автор/кол-во коммитов",
                filterMethod: (filter, rows) =>
                    matchSorter(rows, filter.value, {
                        keys: ["authors"]
                    }),
                accessor: d => {
                    let values = "";
                    d.authors.map(
                        value =>
                            (values += value.name + "(" + value.changes + ")")
                    );
                    return values;
                },
                filterAll: true
            }
        ];

        return (
            <div className="flex-center position-ref full-height">
                <div className="content">
                    {this.state.error ? (
                        <div className="alert alert-danger">
                            {this.state.error}
                        </div>
                    ) : null}

                    <form onSubmit={this.handleSubmit}>
                        <div className="form-group">
                            <label htmlFor="example-date-input">
                                URL like:
                                https://github.com/Denkong/Laravel-React-Redux
                            </label>

                            <input
                                type="text"
                                className="form-control"
                                name="gitRepo"
                                aria-describedby="emailHelp"
                                placeholder="Git Repository"
                                value={this.state.gitRepo}
                                onChange={this.handleChange}
                            />
                        </div>

                        <div className="form-group">
                            <label htmlFor="example-date-input">
                                Начало активности
                            </label>

                            <input
                                className="form-control"
                                type="date"
                                name="dateStart"
                                onChange={this.handleChange}
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="example-date-input">
                                Конец активности
                            </label>

                            <input
                                className="form-control"
                                type="date"
                                name="dateEnd"
                                onChange={this.handleChange}
                            />
                        </div>
                        <input
                            type="submit"
                            className="btn btn-primary"
                            value="Отправить"
                        />
                    </form>
                </div>

                {/**вставляем таблицу если есть данные */}
                {this.state.listFiles && (
                    <ReactTable
                        defaultPageSize={5}
                        defaultFilterMethod={(filter, row) =>
                            matchSorter(rows, filter.value, {
                                keys: ["lastName"]
                            })
                        }
                        filterable
                        data={data}
                        columns={columns}
                    />
                )}
            </div>
        );
    }
}

if (document.getElementById("example")) {
    ReactDOM.render(<Example />, document.getElementById("example"));
}
