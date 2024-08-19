@props(['chat_id'])
<div class="card mt-3">
    <h2 class="text text-center mt-2"> Xabarlar</h2>
    <div class="card-body m-3 ">
        <div class="card w-75 float-start m-2"
             style="box-shadow: 0px 0px 4px 4px #dbdcde; border-radius: 0px 25px 25px 50px; border: 2px solid darkblue  ">
            <div class="p-3">
                <p style="color: darkblue;"><i class="bi bi-person-circle" style="font-size: 30px;"></i> Asadbek </p>
                <p style="color: black">HI
                    <span class="float-end"><i class="bi bi-clock"></i> {{ date('d/m/y H:i', strtotime(now())) }}</span>
                </p>
            </div>
        </div>

        <div class="card w-75 float-end m-2 chat"
             style="box-shadow: 0px 0px 4px 4px #e1e3e5;border-radius: 25px 50px 0px 25px; border: 2px solid darkblue">
            <div class="p-3">
                <p style="color: darkblue"><i class="bi bi-person-circle" style="font-size: 30px;"></i>Bekmurod</p>
                <p style="color: black">How are you
                    <span class="float-end"> <i class="bi bi-clock"></i> {{ date('d/m/y H:i', strtotime(now())) }}
                        @if(true)
                            <i class="bi bi-check-all" style="font-size: 25px;"></i>
                        @else
                            <i class="bi bi-check" style="font-size: 25px;"></i>
                        @endif
                    </span>
                </p>
            </div>
        </div>

    </div>
</div>
<div class="card">
    <form action="#" class="m-3" method="post">
        @csrf
        <input type="hidden" name="chat_id" value="{{ $chat_id }}">
        <input type="hidden" name="type" value="1">
        <div class="input-group">
            <input class="form-control" placeholder="Xabar matni..." type="text" name="message">
            <button class=" btn btn-primary" type="submit"><i class="bx bxl-telegram"></i> Yuborish</button>
        </div>
    </form>
</div>
<script>
    window.scrollTo(0, document.body.scrollHeight);
</script>
