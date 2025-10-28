<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <div class="new-msg-send">
            <label style="cursor: pointer;">
                <img src="{{ asset('assets/images/design-images/All/smile.svg') }}" alt="" style="width: 24px;">
                <input disabled='disabled' type="file" class="upload-attachment" name="file"
                    accept="image/*, .txt, .rar, .zip" style="display:none;" />
            </label>
            <textarea style="height: 39px; width: 92%; padding: 9px;"
                readonly='readonly' name="message" class="m-send app-scroll"
                placeholder="Type Your Message Here"></textarea>
        </div>
        <button disabled='disabled'>
                           <img src="{{ asset('assets/images/design-images/All/send.svg') }}" alt="">
        </button>
    </form>
</div>
