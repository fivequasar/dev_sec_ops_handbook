<?php

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Prox

?>

<x-app-layout class="font-sans">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    @include('profile.partials.update-profile-information-form')


                    @include('profile.partials.update-password-form')



                    @include('profile.partials.delete-user-form')

        </div>
    </div>
</x-app-layout>
