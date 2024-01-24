import axios from "axios";
import React, { Component, useState } from "react";
import { createRoot } from "react-dom/client";
import { sum } from "lodash";
import Swal from "sweetalert2";

class Cart extends Component {
    constructor(props) {
        super(props);
        this.state = {
            cart: [],
            barcode: "",
            products: [],
            search: "",
            customers: [],
            customer_id: "",
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
        axios.get("/admin/cart").then((res) => {
            const cart = res.data;
            this.setState({ cart });
        });
    }

    handleScanBarcode(event) {
        event.preventDefault();
        const { barcode } = this.state;
        if (!!barcode) {
            axios
                .post("cart", { barcode })
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
        const cart = this.state.cart.map((c) => {
            if (c.id === product_id) {
                c.pivot.quantity = qty;
            }
            return c;
        });

        this.setState({ cart });

        axios
            .post("/admin/cart/change-qty", { product_id, quantity: qty })
            .then((res) => {})
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: err.response.data.message,
                });
            });
    }

    getTotal(cart) {
        const total = cart.map((c) => {
            return c.pivot.quantity * c.price;
        });
        return sum(total).toFixed(2);
    }

    handleClickDelete(product_id) {
        axios
            .post("/admin/cart/delete", { product_id, _method: "DELETE" })
            .then((res) => {
                const cart = this.state.cart.filter((c) => c.id !== product_id);
                this.setState({ cart: cart });
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
            .post("/admin/cart/empty", { _method: "DELETE" })
            .then((res) => {
                this.setState({ cart: [] });
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
        console.log(product.quantity);
        if (!!product) {
            let ok_update = false;

            let cart = this.state.cart.find((c) => c.id === product.id);
            if (!!cart) {
                // update quantity
                this.setState({
                    cart: this.state.cart.map((c) => {
                        if (c.id === product.id) {
                            if (product.quantity > c.pivot.quantity) {
                                c.pivot.quantity = c.pivot.quantity + 1;
                                ok_update = true;
                                console.log("added");
                            } else {
                                c.pivot.quantity = product.quantity;
                                ok_update = true;
                            }
                        }
                        return c;
                    }),
                });
            } else {
                if (product.quantity > 0) {
                    product = {
                        ...product,
                        pivot: {
                            quantity: 1,
                            product_id: product.id,
                            user_id: 1,
                        },
                    };

                    this.setState({ cart: [...this.state.cart, product] });
                    ok_update = true;
                }
            }
            if (ok_update) {
                axios
                    .post("cart", { product_id })
                    .then((res) => {
                        this.loadCart();
                        //this.setState({ produc_id: "" });
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
    }

    loadCustomers() {
        axios
            .get(`/admin/customers`)
            .then((res) => {
                const customers = res.data;
                this.setState({ customers: customers });
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
        this.setState({ customer_id: event.target.value });
    }

    handleClickSubmi() {
        if (this.state.customer_id > 0) {
            Swal.fire({
                title: "Received amount",
                input: "text",
                inputValue: this.getTotal(this.state.cart),
                inputAttributes: {
                    autocapitalize: "off",
                },
                showCancelButton: true,
                confirmButtonText: "Save",
                showLoaderOnConfirm: true,
                preConfirm: async (amount) => {
                    axios
                        .post(`/admin/orders`, {
                            customer_id: this.state.customer_id,
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
                title: "Select customer.",
                text: "Please select the customer to sumbit an order",
            });
        }
    }
    render() {
        const { cart, products, barcode, customers } = this.state;

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
                                {customers.map((c) => {
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
                                {console.log(customers)}
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
                                        {cart.map((c) => {
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
                                                            c.price *
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
                                {this.getTotal(cart)}{" "}
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
                                disabled={!cart.length}
                            >
                                Cancel
                            </button>
                        </div>
                        <div className="col">
                            <button
                                type="button"
                                className="btn btn-primary btn-block"
                                disabled={!cart.length}
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
                                    <img src={p.image_url} alt={p.name} />
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

if (document.getElementById("cart")) {
    const rootElement = document.getElementById("cart");

    const root = createRoot(rootElement);

    root.render(<Cart />);
}
