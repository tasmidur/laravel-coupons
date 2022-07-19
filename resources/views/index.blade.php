<html>
<head>
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        #App {
            margin: 20px;
            padding: 20px;
        }

        .div_Master {
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div id="App">
    <h3 style="margin-top: 20px;text-align: center;">Coupon Management</h3>
    <hr>
    <div class="div_Master">
        <form>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="couponType">CouponType</label>
                    <select id="couponType" class="form-control" v-model="couponType" required>
                        <option selected value="Select">Select</option>
                        <option value="FIXED_PRICE">Fixed Price</option>
                        <option value="DISCOUNT_PRICE">Discount Price</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="couponPrice">CouponPrice</label>
                    <input type="number" class="form-control" id="couponPrice" placeholder="CouponPrice"
                           v-model="couponPrice" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="expiredAt">ExpiredAt</label>
                    <input type="datetime-local" class="form-control" id="expiredAt" placeholder="expiredAt"
                           v-model="expiredAt">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary" v-on:click="btnSubmit()" style="float: right">
                        @{{btnMode}}
                    </button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Coupon Code</th>
            <th scope="col">Coupon Type</th>
            <th scope="col">Price</th>
            <th scope="col">Expired At</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="coupon in coupons">
            <td>@{{coupon.coupon_code}}</td>
            <td>@{{coupon.coupon_type}}</td>
            <td>@{{coupon.price}}</td>
            <td>@{{coupon.expired_at}}</td>
            <td>@{{coupon.status}}</td>
            <td>
                <div v-if="Editmode">
                    <button class="btn btn-primary btn-sm" v-on:click="OnEdit(coupon.id)">Edit</button>
                    <button class="btn btn-danger btn-sm" v-on:click="OnDelete(coupon.id)">Delete</button>
                </div>
                <div v-if="updatemode"><button class="btn btn-info btn-sm">update</button> <a class="btn btn-danger btn-sm">Cancel</a> </div>
            </td>
        </tr>
        </tbody>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </table>
</div>
</body>
<script>
    $(() => {
        const app = new Vue({
            el: '#App',
            data: {
                couponType: 'Select',
                couponPrice: 0,
                expiredAt: '',
                formData: {},
                coupons: [],
                Editmode: true,
                updatemode: false,
                btnMode: "Submit",
                Validate: 0,
                Id: 1
            },
            methods: {
                getAll: async function () {
                    axios.get('http://localhost:8001/get-coupon-list')
                        .then((response) => {
                            let responseData = response.data;
                            if (responseData.statusCode === 200) {
                                this.coupons = responseData.data;
                                this.getAll();
                            }
                        }).catch(err => console.error(err));
                },
                btnSubmit: function () {
                    this.formData = {
                        coupon_type: this.couponType,
                        coupon_price: this.couponPrice,
                        expired_at: this.expiredAt
                    };
                    if (this.btnMode === "Update") {
                        this.btnMode = "Submit";
                    }
                    axios.post('http://localhost:8001/coupons', this.formData)
                        .then((response) => {
                            this.formData = {};
                        })
                },
                OnEdit: function (d) {
                    let fitdata = (this.coupons).filter(function (val) {
                        return val.id === d
                    });
                    this.id = fitdata[0].id;
                    this.couponType = fitdata[0].coupon_type;
                    this.couponPrice = fitdata[0].emailid;
                    this.expiredAt = fitdata[0].expired_at;
                    this.btnMode = "Update";
                    this.coupons = (this.coupons).filter(function (val) {
                        return val.id !== d
                    });
                },

                OnDelete: function (d) {
                    this.coupons = (this.coupons).filter(function (val) {
                        return val.Id !== d
                    });
                }
            },
            created() {
                this.getAll();
            }
        });
    })
</script>
</html>
