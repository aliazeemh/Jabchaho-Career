<div class="card sidenav">
    <h6 class="card-header">Fill Application Form</h6>
    <ul class="list-group list-group-flush">
        <li class="list-group-item @if(Request::segment(1) =='personal-details') active @endif "><a href="{{ route('personal.details.show') }}">Personal Information</a></li>
        <li class="list-group-item dropdown @if(Request::segment(1) =='educational-qualification' || Request::segment(1) =='diploma'|| Request::segment(1) =='certification') active @endif ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"  data-bs-toggle="dropdown">Education</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li class="dropdown-item @if(Request::segment(1) =='educational-qualification') active @endif "><a href="{{ route('educational.qualification.show') }}">Qualification </a></li>
                <li class="dropdown-item @if(Request::segment(1) =='diploma') active @endif "><a href="{{ route('diploma.show') }}">Diploma</a></li> 
                <li class="dropdown-item @if(Request::segment(1) =='certification') active @endif "><a href="{{ route('certification.show') }}">Certification</a></li>    
            </ul>
        </li>
        <li class="list-group-item @if(Request::segment(1) =='professional-experience') active @endif "><a href="{{ route('professional.experience.show') }}">Professional Experience</a></li>
        <li class="list-group-item @if(Request::segment(1) =='skill-set') active @endif "><a href="{{ route('skillset.show') }}">Competencies</a></li>
        <li class="list-group-item @if(Request::segment(1) =='referral') active @endif "><a href="{{ route('referral.show') }}">References & Referrals</a></li>
        <li class="list-group-item @if(Request::segment(1) =='family-details') active @endif "><a href="{{ route('family.details.show') }}">Family Details</a></li>
        <li class="list-group-item @if(Request::segment(1) =='upload-documents') active @endif "><a href="{{ route('upload.documents.show') }}">Resume & Documents Upload</a></li>
        <li class="list-group-item @if(Request::segment(1) =='portfolio') active @endif "><a href="{{ route('portfolio.show') }}">Portfolio & other attachments</a></li>
     
    </ul>
</div>