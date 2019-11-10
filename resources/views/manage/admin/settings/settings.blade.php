@extends('manage.admin.controlpanel')

@section('content')
<nav class="breadcrumb  is-small" aria-label="breadcrumbs">
    <ul>
        <li><a href="/manage">{{ Auth::user()->name }}</a></li>
        <li><a href="/manage/profile">Admin</a></li>
        <li class="is-active"><a href="{{ route('settings.index') }}">Settings</a></li>
    </ul>
</nav>

<div class="columns">
    <div class="column is-6">
        <h4 class="title is-size-4 has-text-weight-bold">Settings</h4>
        <p class="subtitle is-size-7">Edit your system settings from here<b class="force-bold"></b></p>
    </div>
</div>

<<<<<<< Updated upstream
<form action="{{ route('settings.store') }}" method="post">
    @csrf
    <div class="tile is-ancestor">
        <div class="tile is-vertical is-4">
            <div class="tile is-parent">
                <article class="tile is-child">
                    <div class="box">
                        <div class="field">
                            <label class="label">Hostname</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="hostname" value="{{ $settings->hostname }}">
                                <span class="icon is-left">
                                    <i class="fas fa-server"></i>
                                </span>
                                @error('hostname')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>           
                        </div>
                        <div class="field">
                            <label class="label">Port</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="hostname_port" value="{{ $settings->hostname_port }}">
                                <span class="icon is-left">
                                    <i class="fas fa-network-wired"></i>
                                </span>
                                    @error('hostname_port')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">RCON Port</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="rcon_port" value="{{ $settings->rcon_port }}">
                                <span class="icon is-left">
                                    <i class="fas fa-file-import"></i>
                                </span>
                                    @error('rcon_port')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">RCON Password</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="rcon_password" value="{{$settings->rcon_password }}">
                                <span class="icon is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                                    @error('rcon_password')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                            </div>
=======
<div id="settings">
    <form action="{{ route('settings.store') }}" method="post">
        @csrf
        <div class="tile is-ancestor">
            <div class="tile is-vertical is-4">
                <div class="tile is-parent">
                    <article class="tile is-child">
                        <div class="box">
                            <template>
                                <div class="field">
                                    <label class="label">โฮสต์</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="hostname" v-model="hostname">
                                        <span class="icon is-left">
                                            <i class="fas fa-server"></i>
                                        </span>
                                        @error('hostname')
                                            <p class="help is-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">พอร์ท</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="hostname_port" value="{{ $settings->hostname_port }}">
                                        <span class="icon is-left">
                                            <i class="fas fa-network-wired"></i>
                                        </span>
                                            @error('hostname_port')
                                                <p class="help is-danger">{{ $message }}</p>
                                            @enderror
                                    </div>
                                </div>

                                <b-tabs type="is-small">
                                    <b-tab-item label="Rcon" icon="lan-connect">
                                        <div class="field">
                                            <label class="label">พอร์ท RCON</label>
                                            <div class="control has-icons-left">
                                                <input class="input" type="text" name="rcon_port" value="{{ $settings->rcon_port }}">
                                                <span class="icon is-left">
                                                    <i class="fas fa-file-import"></i>
                                                </span>
                                                @error('rcon_port')
                                                    <p class="help is-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label class="label">รหัสผ่านของ RCON</label>
                                            <div class="control has-icons-left">
                                                <input class="input" type="text" name="rcon_password" value="{{$settings->rcon_password }}">
                                                <span class="icon is-left">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                                @error('rcon_password')
                                                    <p class="help is-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </b-tab-item>
                                    <b-tab-item label="WebSender" icon="power-plug">
                                        <div class="field">
                                            <label class="label">พอร์ท WebSender</label>
                                            <div class="control has-icons-left">
                                                <input class="input" type="text" name="websender_port" value="{{ $settings->websender_port }}">
                                                <span class="icon is-left">
                                                    <i class="fas fa-file-import"></i>
                                                </span>
                                                @error('rcon_port')
                                                    <p class="help is-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label class="label">รหัสผ่านของ WebSender</label>
                                            <div class="control has-icons-left">
                                                <input class="input" type="text" name="websender_password" value="{{$settings->websender_password }}">
                                                <span class="icon is-left">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                                @error('rcon_password')
                                                    <p class="help is-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </b-tab-item>
                                    <div class="content is-small" style="margin-top: 2em;">
                                        <p>** เมื่อเซิร์ฟเวอร์ไม่สามารถเชื่อมต่อ Rcon ได้ใช้ Websender แทน</p>
                                    </div>
                                </b-tabs>
                            </template>
>>>>>>> Stashed changes
                        </div>
                    </article>
                </div>
            </div>
<<<<<<< Updated upstream
        </div>
        <div class="tile is-vertical is-8">
            <div class="tile is-parent">
                <article class="tile is-child">
                    <div class="box">
                        <div class="field">
                            <label class="label">Website Name</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="website_name" value="{{ $settings->website_name }}">
                                <span class="icon is-left">
                                    <i class="fas fa-server"></i>
                                </span>
=======
            <div class="tile is-vertical is-8">
                <div class="tile is-parent">
                    <article class="tile is-child">
                        <div class="box">
                            <div class="field">
                                <label class="label">ชื่อของเว็บไซต์</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="text" name="website_name" value="{{ $settings->website_name }}">
                                    <span class="icon is-left">
                                        <i class="fas fa-server"></i>
                                    </span>
>>>>>>> Stashed changes
                                    @error('website_name')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
<<<<<<< Updated upstream
                        </div>
                        <div class="field">
                            <label class="label">Website Description</label>
                            <div class="control has-icons-left">
                                <textarea class="textarea" rows="7"type="text" name="website_desc">{{ $settings->website_desc }}</textarea>
=======
                            <div class="field">
                                <label class="label">รายละเอียดต่างๆ เกี่ยวกับเซิร์ฟเวอร์</label>
                                <div class="control has-icons-left">
                                    <textarea class="textarea" rows="12" type="text" name="website_desc">{{ $settings->website_desc }}</textarea>
>>>>>>> Stashed changes
                                    @error('website_desc')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
<<<<<<< Updated upstream
    </div>
    <div class="field">
        <p class="control has-icons-left">
            <button id="submit_button" class="button is-fullwidth is-link is-outlined clickaction" type="submit">Save Settings</button>
        </p>
    </div>
</form>
=======
        <div class="field">
            <p class="control has-icons-left">
                <button id="submit_button" class="button is-fullwidth is-link is-outlined clickaction" type="submit">บันทึกการเปลี่ยนแปลง</button>
            </p>
        </div>
    </form>
</div>
<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/buefy/dist/buefy.min.js"></script>

<script>

    new Vue({
        el: '#settings',

        data: {
            msg: 'ใช้ Hostname เดียวกัน',
            hostname: '{{ $settings->hostname }}',
        },
    })

</script>
>>>>>>> Stashed changes
@endsection
