import axios from "axios";
import React, { Component, useState } from "react";
import { createRoot } from "react-dom/client";
import { sum } from "lodash";
import Swal from "sweetalert2";

class Cart extends Component {
    constructor(props) {
        super(props);
        this.state = {
            purchaseCart: [],
            barcode: "",
            products: [],
            search: "",
            providers: [],
            provider_id: "",
        };

        this.loadCart = this.loadCart.bind(this);
        this.loadProducts = this.loadProducts.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleChangeQty = this.handleChangeQty.bind(this);
        this.handleClickDelete = this.handleClickDelete.bind(this);
        this.handleEmptyCart = this.handleEmptyCart.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSearch = this.handleSearch.bind(this);
        this.addProductToCart = this.addProductToCart.bind(this);
        this.loadCustomers = this.loadCustomers.bind(this);
        this.setCustomerId = this.setCustomerId.bind(this);
        this.handleClickSubmi = this.handleClickSubmi.bind(this);
    }

    componentDidMount() {
        this.loadCart();
        this.loadProducts();
        this.loadCustomers();
    }

    loadProducts(search = "") {
        const query = !!search ? `?search=${search}` : "";
        axios
            .get(`/admin/products${query}`)
            .then((res) => {
                const products = res.data.data;

                this.setState({ products: products });
            })
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: err.response.data.message,
                });
            });
    }

    handleOnChangeBarcode(event) {
        const barcode = event.target.value;
        this.setState({ barcode });
    }
    loadCart() {
        axios.get("/admin/purchaseCart").then((res) => {
            const purchaseCart = res.data;
            this.setState({ purchaseCart });
        });
    }

    handleScanBarcode(event) {
        event.preventDefault();
        const { barcode } = this.state;
        if (!!barcode) {
            axios
                .post("purchaseCart", { barcode })
                .then((res) => {
                    this.loadCart();
                    this.setState({ barcode: "" });
                })
                .catch((err) => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: err.response.data.message,
                    });
                });
        }
    }

    handleChangeQty(product_id, qty) {
        const purchaseCart = this.state.purchaseCart.map((c) => {
            if (c.id === product_id) {
                c.pivot.quantity = qty;
            }
            return c;
        });

        this.setState({ purchaseCart });

        axios
            .post("/admin/purchaseCart/change-qty", {
                product_id,
                quantity: qty,
            })
            .then((res) => {})
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: err.response.data.message,
                });
            });
    }

    getTotal(purchaseCart) {
        const total = purchaseCart.map((c) => {
            return c.pivot.quantity * c.purchase_price;
        });
        return sum(total).toFixed(2);
    }

    handleClickDelete(product_id) {
        axios
            .post("/admin/purchaseCart/delete", {
                product_id,
                _method: "DELETE",
            })
            .then((res) => {
                const purchaseCart = this.state.purchaseCart.filter(
                    (c) => c.id !== product_id
                );
                this.setState({ purchaseCart: purchaseCart });
            })
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: err.response.data.message,
                });
            });
    }

    handleEmptyCart() {
        axios
            .post("/admin/purchaseCart/empty", { _method: "DELETE" })
            .then((res) => {
                this.setState({ purchaseCart: [] });
            })
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: err.response.data.message,
                });
            });
    }

    handleChangeSearch(event) {
        const search = event.target.value;
        this.setState({ search });
    }
    handleSearch(event) {
        if (event.keyCode === 13) {
            this.loadProducts(event.target.value);
        }
    }

    addProductToCart(product_id) {
        let product = this.state.products.find((p) => p.id === product_id);
        if (!!product) {
            let purchaseCart = this.state.purchaseCart.find(
                (c) => c.id === product.id
            );
            if (!!purchaseCart) {
                // update quantity
                this.setState({
                    purchaseCart: this.state.purchaseCart.map((c) => {
                        if (c.id === product.id) {
                            c.pivot.quantity = c.pivot.quantity + 1;
                            console.log("added");
                        }
                        return c;
                    }),
                });
            } else {
                product = {
                    ...product,
                    pivot: {
                        quantity: 1,
                        product_id: product.id,
                        user_id: 1,
                    },
                };

                this.setState({
                    purchaseCart: [...this.state.purchaseCart, product],
                });
            }

            axios
                .post("purchaseCart", { product_id })
                .then((res) => {
                    this.loadCart();
                })
                .catch((err) => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: err.response.data.message,
                    });
                });
        }
    }

    loadCustomers() {
        axios
            .get(`/admin/providers`)
            .then((res) => {
                const providers = res.data;
                this.setState({ providers: providers });
            })
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: err.response.data.message,
                });
            });
    }

    setCustomerId(event) {
        this.setState({ provider_id: event.target.value });
    }

    handleClickSubmi() {
        if (this.state.provider_id > 0) {
            Swal.fire({
                title: "Received amount",
                input: "text",
                inputValue: this.getTotal(this.state.purchaseCart),
                inputAttributes: {
                    autocapitalize: "off",
                },
                showCancelButton: true,
                confirmButtonText: "Save",
                showLoaderOnConfirm: true,
                preConfirm: async (amount) => {
                    axios
                        .post(`/admin/purchases`, {
                            provider_id: this.state.provider_id,
                            amount,
                        })
                        .then((res) => {
                            this.loadCart();
                            this.loadProducts();
                        })
                        .catch((err) => {
                            Swal.fire({
                                icon: "error",
                                // title: "Oops...",
                                text: err.response.data.message,
                            });
                        });
                },
                allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.isConfirmed) {
                    /*  Swal.fire({
                    title: `Saved correctly`,
                    //imageUrl: result.value.avatar_url,
                }); */
                }
            });
        } else {
            Swal.fire({
                icon: "warning",
                title: "Select provider.",
                text: "Please select the provider to sumbit an order",
            });
        }
    }
    render() {
        const { purchaseCart, products, barcode, providers } = this.state;

        return (
            <div className="row">
                <div className="col-md6 col-lg-4">
                    <div className="row mb-2">
                        <div className="col">
                            <form onSubmit={this.handleScanBarcode}>
                                <input
                                    type="text"
                                    className="form-control"
                                    placeholder="Scan Barcode"
                                    value={barcode}
                                    onChange={this.handleOnChangeBarcode}
                                />
                            </form>
                        </div>
                        <div className="col">
                            <div className="row"></div>
                            <select
                                id="custom-select"
                                className="custom-select"
                                onChange={(e) => this.setCustomerId(e)}
                            >
                                <option
                                    key="-1"
                                    value="-1"
                                    defaultValue=""
                                ></option>
                                {providers.map((c) => {
                                    return (
                                        <option
                                            key={c.id}
                                            value={c.id}
                                            defaultValue=""
                                        >
                                            {c.first_name} {c.last_name}
                                        </option>
                                    );
                                })}
                                {console.log(providers)}
                            </select>
                        </div>
                    </div>

                    <div className="user-cart">
                        <div className="card">
                            <div className="table-wrapper-scroll-y my-custom-scrollbar">
                                <table className="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th className="text-right">
                                                Price
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {purchaseCart.map((c) => {
                                            return (
                                                <tr key={c.id}>
                                                    <td>{c.name}</td>
                                                    <td>
                                                        <input
                                                            type="text"
                                                            className="form-control form-control-sm qty"
                                                            value={
                                                                c.pivot.quantity
                                                            }
                                                            onChange={(e) =>
                                                                this.handleChangeQty(
                                                                    c.id,
                                                                    e.target
                                                                        .value
                                                                )
                                                            }
                                                        />
                                                        <button
                                                            className="btn btn-danger btn-sm"
                                                            onClick={(e) =>
                                                                this.handleClickDelete(
                                                                    c.id
                                                                )
                                                            }
                                                        >
                                                            {" "}
                                                            <i className="fas fa-trash"></i>{" "}
                                                        </button>
                                                    </td>
                                                    <td className="text-right">
                                                        {" "}
                                                        {(
                                                            c.purchase_price *
                                                            c.pivot.quantity
                                                        ).toFixed(2)}
                                                    </td>
                                                </tr>
                                            );
                                        })}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div className="row  mb-4">
                        <div className="col">
                            <div className="pos_total_label">Total:</div>
                        </div>
                        <div className="col tex-right">
                            <div className="pos_total">
                                {this.getTotal(purchaseCart)}{" "}
                                {window.APP.currency_symbol}
                            </div>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col">
                            <button
                                type="button"
                                className="btn btn-danger btn-block"
                                onClick={this.handleEmptyCart}
                                disabled={!purchaseCart.length}
                            >
                                Cancel
                            </button>
                        </div>
                        <div className="col">
                            <button
                                type="button"
                                className="btn btn-primary btn-block"
                                disabled={!purchaseCart.length}
                                onClick={this.handleClickSubmi}
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
                <div className="col-md6 col-lg-8">
                    <div className="mb-2">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Search product"
                            onChange={this.handleChangeSearch}
                            onKeyDown={this.handleSearch}
                        />
                    </div>
                    {products.map((p) => {
                        return (
                            <div
                                key={p.id}
                                className="order-product"
                                onClick={() => this.addProductToCart(p.id)}
                            >
                                <div className="item">
                                    <img src={p.image_url} alt="" />
                                    <h5>( {p.quantity} )</h5>
                                    <h5>{p.name}</h5>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        );
    }
}

export default Cart;

if (document.getElementById("purchaseCart")) {
    const rootElement = document.getElementById("purchaseCart");

    const root = createRoot(rootElement);

    root.render(<Cart />);
}
