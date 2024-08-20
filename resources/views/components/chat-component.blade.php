@props(['friend'])
<div class="card mt-3">
    <?php
    $messages = (new \App\Http\Controllers\ChatController())->messages($friend);
    ?>
    <div class="card-body m-3" style="height: 500px; overflow-y: scroll; overflow-x: hidden;">
        @foreach($messages as $message)
            <div class="card w-75 @if($message->sender_id !== auth()->id()) float-start @else float-end @endif m-2"
                 style="box-shadow: 0px 0px 4px 4px #dbdcde; border-radius: 0px 25px 25px 50px; border: 2px solid darkblue  ">
                <div class="p-3">
                    <p style="color: darkblue;"><i class="bi bi-person-circle"
                                                   style="font-size: 30px;"></i> {{ $message->sender->name }}
                    </p>
                    <p style="color: black">{{ $message->text }}
                        <span class="float-end"><i class="bi bi-clock"></i> {{ date('d/m/y H:i', strtotime($message->created_at)) }}
                            @if($message->sender_id === auth()->id())
                                @if($message->is_read)
                                    <i class="bi bi-check-all" style="font-size: 25px;"></i>
                                @else
                                    <i class="bi bi-check" style="font-size: 25px;"></i>
                                @endif
                            @endif
                        </span>
                    </p>
                </div>
            </div>
        @endforeach

    </div>
</div>
<div class="card">
    <form action="/messages/{{ $friend->id }}" class="m-3" method="post">
        @csrf
        <div class="input-group">
            <input class="form-control" placeholder="Xabar matni..." type="text" name="message">
            <button class=" btn btn-primary" type="submit"><i class="bx bxl-telegram"></i> Yuborish</button>
        </div>
    </form>
</div>
<script>
    window.scrollTo(0, document.body.scrollHeight);
</script>
