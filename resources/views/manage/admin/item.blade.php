@extends('manage.admin.controlpanel')

@section('breadcrumb')

<nav class="breadcrumb is-small" aria-label="breadcrumbs">
    <ul>
        <li><a href="{{ route('profile.index') }}">{{ Auth::user()->name }}</a></li>
        <li><a href="{{ route('admin.controlpanel') }}">Admin</a></li>
        <li class="is-active"><a aria-current="page">Itemshop</a></li>
    </ul>
</nav>
@endsection

@section('content')

<div id="itemshop">
    <div class="columns">
        <div class="column is-6">
            <h4 class="title is-size-4">ร้านค้า</h4>
            <p class="subtitle is-size-7">จัดการหน้าร้านค้าเพื่อให้ผู้เล่นซื้อสินค้า<b class="force-bold"></b></p>
        </div>
        <div class="buttons column is-6 has-text-right">
            <a class="button is-small is-white is-shadow" @click="isAddItemModalActive = true">
                <b-icon icon="gift" size="is-small"></b-icon>
                <span>เพิ่มไอเท็มใหม่</span>
            </a>
            <a class="button is-small is-white is-shadow" @click="isAddCategoryModalActive = true">
                <b-icon icon="gift" size="is-small"></b-icon>
                <span>เพิ่มหมวดหมู่ใหม่</span>
            </a>
        </div>
    </div>

    <div class="field">
        <div class="columns">
            <div class="column is-12" style="height: 100%">
                <template>
                    <section>
                        <b-table class="has-text-weight-medium is-size-7" type="is-small" :data="data" :paginated="true"
                            :per-page="5" :pagination-simple="true" :selected.sync="selected" :mobile-cards="false">

                            <template slot-scope="props">
                                <b-table-column field="item_id" label="เลขอ้างอิง" width="80" sortable centered>
                                    @{{ props.row.item_id }}
                                </b-table-column>

                                <b-table-column field="item_name" label="ชื่อไอเท็ม">
                                    @{{ props.row.item_name }}
                                </b-table-column>

                                <b-table-column field="item_desc" label="รายละเอียดโดยย่อ">
                                    @{{ props.row.item_desc }}
                                </b-table-column>

                                <b-table-column field="item_price" label="ราคา" centered>
                                    @{{ props.row.item_price }}
                                </b-table-column>

                                <b-table-column field="item_sold" label="ขายไปแล้ว" centered>
                                    @{{ props.row.item_sold || "ยังไม่มี" }}
                                </b-table-column>
                            </template>

                        </b-table>
                        <div class="has-text-weight-medium is-size-7" style="margin-top: -1.75rem"
                            v-if="selected != null">

                            <b-tabs size="is-small" class="block">
                                <b-tab-item label="แก้ไข" icon="pencil-box-outline">

                                    <div class="level">
                                        <div class="level-left">
                                            <div>
                                                <h6 class="title is-size-6">แก้ไขไอเท็ม @{{ selected.item_name }}</h6>
                                                <p class="subtitle is-size-7">
                                                    ผลของการแก้ไขจะเปลี่ยนแปลงเมื่อกดปุ่มบันทึก<b
                                                        class="force-bold"></b></p>
                                            </div>
                                        </div>
                                        <div class="level-right has-text-right">
                                            <form method="POST" action="{{ route('redeem.internalDelete') }}">
                                                @csrf
                                                <input type="hidden" name="id" v-bind:value="selected.redeem_id">
                                                <button type="submit"
                                                    class="button is-small is-outlined is-danger">ลบโค๊ด
                                                    @{{ selected.item_name || "" }}</buttontype="hidden">
                                            </form>
                                        </div>
                                    </div>

                                    <section>
                                        <form method="POST" action="{{ route('itemshop.internalUpdate') }}"
                                            enctype="multipart/form-data">

                                            @csrf

                                            <input type="hidden" name="id" v-bind:value="selected.item_id">

                                            <b-field type="is-small" message="** จำกัด 30 ตัวอักษร">
                                                <b-input type="text" placeholder="ไอเท็ม" name="item_name"
                                                    v-bind:value="selected.item_name" maxlength="30"></b-input>
                                            </b-field>

                                            <b-field type="is-small">
                                                <b-input rows="2" type="textarea" placeholder="รายละเอียดโดยย่อ"
                                                    name="item_desc" v-bind:value="selected.item_desc"></b-input>
                                            </b-field>

                                            <b-field type="is-small" label="ราคา" horizontal>
                                                <b-numberinput size="is-small" name="item_price"
                                                    v-bind:value="selected.item_price" min="0">
                                                </b-numberinput>
                                            </b-field>

                                            <b-field type="is-small" label="ลดเหลือ" horizontal
                                                v-if="selected.item_discount_price">
                                                <b-numberinput size="is-small" name="item_discount_price"
                                                    v-bind:value="selected.item_discount_price" min="0" step="15">
                                                </b-numberinput>
                                            </b-field>

                                            <b-field type="is-small" label="ตัวเลือกพิเศษ" horizontal>
                                                <b-checkbox
                                                    v-bind:value="isAlreadyDiscont(selected.item_discount_price)"
                                                    size="is-small" style="is-info">
                                                    มีการลดราคา
                                                </b-checkbox>
                                            </b-field>

                                            <b-field label="หมวดหมู่" horizontal>
                                                <b-select placeholder="หมวดสินค้า" size="is-small" name="category"
                                                    v-model="selected.category_id" expanded>
                                                    @foreach ($categorys as $key => $category)
                                                    <option value="{{ $category->category_id }}">
                                                        {{ ucwords($category->category_name) }}</option>
                                                    @endforeach
                                                </b-select>
                                            </b-field>

                                            <b-field label="ภาพประกอบ" horizontal>
                                                <figure class="image is-128x128">
                                                    <img :src="'/storage/itemshop/cover/' + selected.item_image_path">
                                                </figure>
                                                <input type="file" name="cover">
                                            </b-field>

                                            <b-tabs size="is-small" class="block">

                                                <b-tab-item label="คำสั่งของรางวัล" icon="code-braces">
                                                    <b-input size="is-small" type="textarea" name="item_command"
                                                        placeholder="คำสั่งของรางวัลที่จะได้รับเมื่อแลก" rows="4"
                                                        v-model="selected.item_command"></b-input>
                                                </b-tab-item>

                                                <b-tab-item label="วิธีการใช้" icon="comment-question-outline">
                                                    <b-message title="รูปแบบวิธีการใช้คำสั่ง" size="is-small">
                                                        <p>
                                                            <table class="table is-fullwidth">
                                                                <tbody>
                                                                    <tr>
                                                                        <th width="40%"><b>cmd: <คำสั่ง></b></th>
                                                                        <th>ใช้ส่งคำสั่งไปเซิร์ฟเวอร์</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="40%"><b>%player</b></th>
                                                                        <th>ใช้แทนชื่อคนแลกในคำสั่ง</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="40%"><b>points: <พ้อย></b></th>
                                                                        <th>ให้ Point บนเว็บ</th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <b class="force-bold has-text-primary">EXAMPLE:
                                                            </b>ให้เพชรและให้ 25 Point <br>
                                                            <b>cmd:give %player diamond 64;point:25</b>
                                                        </p>
                                                    </b-message>
                                                </b-tab-item>
                                            </b-tabs>

                                            <div class="buttons">
                                                <b-button type="is-primary" native-type="submit" size="is-small">
                                                    แก้ไขไอเท็ม @{{ selected.item_name || null }}</b-button>
                                            </div>

                                        </form>

                                    </section>

                                </b-tab-item>
                            </b-tabs>
                        </div>

                        <b-modal :active.sync="isAddItemModalActive" :width="720" scroll="keep">
                            <div class="box is-shadowless is-modal">
                                <div class="topic has-text-centered" style="padding: 1.75rem;">
                                    <h4 class="title">เพิ่มไอเท็มใหม่</h4>
                                    <p class="subtitle is-6">โหมดละเอียด</p>
                                </div>

                                <b-steps size="is-small">
                                    <b-step-item label="รายละเอียด" icon="account">
                                        <div style="padding: 3rem 3rem;">
                                            <b-field label="ชื่อผู้ใช้">
                                                <b-input placeholder=""></b-input>
                                            </b-field>
                                            <b-field label="อีเมล">
                                                <b-input placeholder=""></b-input>
                                            </b-field>

                                            <b-field label="ภาพโปรไฟล์">
                                                <b-upload v-model="file">
                                                    <a class="button is-primary">
                                                        <b-icon icon="upload"></b-icon>
                                                        <span>Click to upload</span>
                                                    </a>
                                                </b-upload>
                                                <span class="file-name" v-if="file">
                                                    @{{ file.name }}
                                                </span>
                                            </b-field>

                                            <div class="buttons is-right">
                                                <b-button type="is-primary is-outlined">ต่อไป</b-button>
                                            </div>
                                        </div>
                                    </b-step-item>
                                    <b-step-item label="ราคา" icon="cash-usd">
                                        <div style="padding: 3rem 3rem;">
                                            <b-field label="พ้อยท์เริ่มต้น">
                                                <b-input placeholder=""></b-input>
                                            </b-field>
                                            <b-field label="เงินในเกมเริ่มต้น">
                                                <b-input placeholder=""></b-input>
                                            </b-field>

                                            <div class="buttons is-right">
                                                <b-button type="is-primary is-outlined">ต่อไป</b-button>
                                            </div>
                                        </div>
                                    </b-step-item>
                                    <b-step-item label="ตรวจสอบ" icon="check"></b-step-item>
                                </b-steps>
                            </div>
                        </b-modal>

                        <b-modal :active.sync="isAddCategoryModalActive" :width="720" scroll="keep">
                            <div class="box is-shadowless is-modal">
                                <div class="topic has-text-centered" style="padding: 1.75rem;">
                                    <h4 class="title">เพิ่มหมวดใหม่</h4>
                                    <p class="subtitle is-6">โหมดละเอียด</p>
                                </div>

                                <b-steps size="is-small">
                                    <b-step-item label="ทั่วไป" icon="account">
                                        <div style="padding: 3rem 3rem;">
                                            <b-field label="ชื่อผู้ใช้">
                                                <b-input placeholder=""></b-input>
                                            </b-field>
                                            <b-field label="อีเมล">
                                                <b-input placeholder=""></b-input>
                                            </b-field>

                                            <b-field label="ภาพโปรไฟล์">
                                                <b-upload v-model="file">
                                                    <a class="button is-primary">
                                                        <b-icon icon="upload"></b-icon>
                                                        <span>Click to upload</span>
                                                    </a>
                                                </b-upload>
                                                <span class="file-name" v-if="file">
                                                    @{{ file.name }}
                                                </span>
                                            </b-field>

                                            <div class="buttons is-right">
                                                <b-button type="is-primary is-outlined">ต่อไป</b-button>
                                            </div>
                                        </div>
                                    </b-step-item>
                                    <b-step-item label="การเชื่อมต่อ" icon="cash-usd">
                                        <div style="padding: 3rem 3rem;">
                                            <b-field label="พ้อยท์เริ่มต้น">
                                                <b-input placeholder=""></b-input>
                                            </b-field>
                                            <b-field label="เงินในเกมเริ่มต้น">
                                                <b-input placeholder=""></b-input>
                                            </b-field>

                                            <div class="buttons is-right">
                                                <b-button type="is-primary is-outlined">ต่อไป</b-button>
                                            </div>
                                        </div>
                                    </b-step-item>
                                    <b-step-item label="การส่งคำสั่ง" icon="settings"></b-step-item>
                                    <b-step-item label="ตรวจสอบ" icon="check"></b-step-item>
                                </b-steps>
                            </div>
                        </b-modal>

                    </section>
                </template>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/buefy/dist/buefy.min.js"></script>

<script>
    new Vue({
        el: '#itemshop',
        methods: {
            isAlreadyDiscont: function (value) {
                if (value > 0) {
                    return true
                } else {
                    return false
                }
            },
            setNullImage: function () {
                this.file = null
            },
        },
        data() {
            return {
                data,
                selected: data[-1],
                columns: [{
                        field: 'item_id',
                        label: 'เลขอ้างอิง',
                    },
                    {
                        field: 'item_name',
                        label: 'ชื่อไอเท็ม',
                    },
                    {
                        field: 'item_desc',
                        label: 'รายละเอียดโดยย่อ',
                    },
                    {
                        field: 'item_price',
                        label: 'ราคา',
                    },
                    {
                        field: 'item_sold',
                        label: 'ขายไปแล้ว',
                        centered: true
                    }
                ],
                file: null,
                name: null,
                desc: null,
                price: 0,
                discountprice: 0,
                commands: null,
                isDiscont: false,
                isAddItemModalActive: false,
                isAddCategoryModalActive: false,
            }
        }
    })

</script>
@endsection

@section('quickbar')

<h4 class="title is-size-4">สร้างไอเท็มใหม่</h4>
<p class="subtitle is-size-7">สร้างการแลกใหม่อย่างรวดเร็ว<b class="force-bold"></b></p>

<div id="redeem-quickbar">
    <template>
        <section>

            <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data" class="is-size-7">
                @csrf
                <b-field type="is-small" message="** จำกัด 30 ตัวอักษร">
                    <b-input type="text" placeholder="ไอเท็ม" name="item_name" v-model="name" maxlength="30"></b-input>
                </b-field>

                <b-field type="is-small">
                    <b-input rows="2" type="textarea" placeholder="รายละเอียดโดยย่อ" name="item_desc" v-model="desc">
                    </b-input>
                </b-field>

                <b-field type="is-small" label="ราคา" horizontal>
                    <b-numberinput size="is-small" name="item_price" v-model="price" min="0" step="15"></b-numberinput>
                </b-field>

                <b-field type="is-small" label="ลดเหลือ" horizontal v-if="isDiscount === true">
                    <b-numberinput size="is-small" name="item_discount_price" v-model="discountprice" min="0" step="15">
                    </b-numberinput>
                </b-field>

                <b-field type="is-small">
                    <b-checkbox v-model="isDiscont" size="is-small">
                        มีการลดราคา
                    </b-checkbox>
                </b-field>

                <b-field label="หมวดหมู่" horizontal>
                    <b-select placeholder="หมวดสินค้า" size="is-small" name="category" expanded>
                        @foreach ($categorys as $key => $category)
                        <option value="{{ $category->category_id }}">{{ ucwords($category->category_name) }}</option>
                        @endforeach
                    </b-select>
                </b-field>

                <b-field label="ภาพประกอบ" horizontal>
                    <input type="file" name="cover">
                </b-field>

                <b-tabs size="is-small" class="block">

                    <b-tab-item label="คำสั่งของรางวัล" icon="code-braces">
                        <b-input size="is-small" type="textarea" name="item_command"
                            placeholder="คำสั่งของรางวัลที่จะได้รับเมื่อแลก" rows="4" v-model="commands"></b-input>
                    </b-tab-item>

                    <b-tab-item label="วิธีการใช้" icon="comment-question-outline">
                        <b-message title="รูปแบบวิธีการใช้คำสั่ง" size="is-small">
                            <p>
                                <table class="table is-fullwidth">
                                    <tbody>
                                        <tr>
                                            <th width="40%"><b>cmd: <คำสั่ง></b></th>
                                            <th>ใช้ส่งคำสั่งไปเซิร์ฟเวอร์</th>
                                        </tr>
                                        <tr>
                                            <th width="40%"><b>%player</b></th>
                                            <th>ใช้แทนชื่อคนแลกในคำสั่ง</th>
                                        </tr>
                                        <tr>
                                            <th width="40%"><b>points: <พ้อย></b></th>
                                            <th>ให้ Point บนเว็บ</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <b class="force-bold has-text-primary">EXAMPLE: </b>ให้เพชรและให้ 25 Point <br>
                                <b>cmd:give %player diamond 64;point:25</b>
                            </p>
                        </b-message>
                    </b-tab-item>
                </b-tabs>

                <div class="buttons">
                    <b-button type="is-primary" native-type="submit" size="is-small">สร้างไอเท็ม
                        @{{ name || null }}</b-button>
                </div>

            </form>

        </section>
    </template>
</div>

<script>
    new Vue({
        el: '#redeem-quickbar',
        data() {
            return {
                file: null,
                name: null,
                desc: null,
                price: 0,
                discountprice: 0,
                commands: null,
                isDiscount: false,
            }
        },
        methods: {
            setNullImage: function () {
                this.file = null
            }
        }
    })

</script>

@endsection
