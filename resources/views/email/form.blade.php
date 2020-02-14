<div class="text-center">
    @if($leave->status == "Pending")
    <h1>Dear, Sir/Madam</h1>
    <p>
        Leave request is added from <b> {{{ $leave->user->name }}}</b>
    </p>
    @else
    <h1>Dear, {{{ $leave->user->name }}}</h1>
    <p>
        Your Leave Has Been <b>{{{ $leave->status == 'Accepted' ? 'Accepted' : 'Rejected' }}}</b>
    </p>
    <p>Information.</p>
    Start at: <p>{{{ $leave->start }}}</p>
    End at: <p>{{{ $leave->end }}}</p>
    @endif
</div>
