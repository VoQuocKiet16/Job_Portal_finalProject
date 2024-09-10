@extends('front.layouts.app')

@section('main')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-12 col-lg-12">
                <form action="{{ route('resume.update', $resume->id) }}" id="editform" class="needs-validation mt-4" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ $resume->user_id }}" />

                    <h4 class="mb-3">Edit Resume</h4>

                    <!-- Personal details fields -->
                    <div class="card mb-3 mt-4">
                        <div class="card-body">
                            <h4 class="mb-3">Personal details</h4>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="first_name" class="form-label">First name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $resume->personalInformation->first_name }}" required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="last_name" class="form-label">Last name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $resume->personalInformation->last_name }}" required>
                                </div>

                                <div class="col-12">
                                    <label for="profile_title" class="form-label">Profile title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="profile_title" name="profile_title" value="{{ $resume->personalInformation->profile_title }}" required>
                                </div>

                                <div class="col-12">
                                    <label for="about_me" class="form-label">Summary<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="about_me" name="about_me" rows="5" required>{{ $resume->personalInformation->about_me }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact details fields -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="mb-3">Contact details</h4>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" class="form-control" id="website" name="website" value="{{ $resume->contactInformation->website }}">
                                </div>

                                <div class="col-6">
                                    <label for="linkedin_link" class="form-label">LinkedIn</label>
                                    <input type="url" class="form-control" id="linkedin_link" name="linkedin_link" value="{{ $resume->contactInformation->linkedin_link }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Education details -->
                    <h4 class="mb-0">Education details</h4>
                    <div class="education_section">
                        @foreach($resume->education as $education)
                        <div class="card section mb-3">
                            <div class="card-body row g-3">
                                <div class="col-sm-12">
                                    <label for="degree_title" class="form-label">Degree<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="degree_title" name="degree_title[]" value="{{ $education->degree_title }}" required>
                                </div>

                                <div class="col-sm-12">
                                    <label for="institute" class="form-label">Institute<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="institute" name="institute[]" value="{{ $education->institute }}" required>
                                </div>

                                <div class="col-6">
                                    <label for="edu_start_date" class="form-label">Start date</label>
                                    <input type="date" class="form-control" id="edu_start_date" name="edu_start_date[]" value="{{ $education->edu_start_date }}" required>
                                </div>

                                <div class="col-6">
                                    <label for="edu_end_date" class="form-label">End date</label>
                                    <input type="date" class="form-control" id="edu_end_date" name="edu_end_date[]" value="{{ $education->edu_end_date }}" required>
                                </div>

                                <div class="col-12">
                                    <label for="education_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="education_description" name="education_description[]" rows="6">{{ $education->education_description }}</textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <button id="add_education" class="btn btn-primary">Add education</button>
                    </div>

                    <!-- Experience details -->
                    <h4 class="mb-0">Experience details</h4>
                    <div class="experience_section">
                        @foreach($resume->experience as $experience)
                        <div class="card section mb-3">
                            <div class="card-body row g-3">
                                <div class="col-sm-12">
                                    <label for="job_title" class="form-label">Job Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="job_title" name="job_title[]" value="{{ $experience->job_title }}" required>
                                </div>

                                <div class="col-sm-12">
                                    <label for="organization" class="form-label">Organization<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="organization" name="organization[]" value="{{ $experience->organization }}" required>
                                </div>

                                <div class="col-6">
                                    <label for="job_start_date" class="form-label">Start date</label>
                                    <input type="date" class="form-control" id="job_start_date" name="job_start_date[]" value="{{ $experience->job_start_date }}" required>
                                </div>

                                <div class="col-6">
                                    <label for="job_end_date" class="form-label">End date</label>
                                    <input type="date" class="form-control" id="job_end_date" name="job_end_date[]" value="{{ $experience->job_end_date }}" required>
                                </div>

                                <div class="col-12">
                                    <label for="job_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="job_description" name="job_description[]" rows="5">{{ $experience->job_description }}</textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <button id="add_experience" class="btn btn-primary">Add experience</button>
                    </div>

                    <!-- Skills -->
                    <h4 class="mb-0">Skills</h4>
                    <div class="skills_section">
                        @foreach($resume->skill as $skill)
                        <div class="card section mb-3">
                            <div class="card-body row g-3">
                                <div class="col-sm-12">
                                    <label for="skills[]" class="form-label">Skill<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="skills" name="skills[]" value="{{ $skill->skill }}" required>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <button id="add_skill" class="btn btn-primary">Add skill</button>
                    </div>
                    
                    <hr class="my-4">
                    <!-- Buttons -->
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <button type="submit" class="btn btn-primary w-100 btn btn-primary btn-lg mb-3">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to add a new education section
        document.getElementById('add_education').addEventListener('click', function(e) {
            e.preventDefault();
            addNewSection('education_section', 'education');
        });
    
        // Function to add a new experience section
        document.getElementById('add_experience').addEventListener('click', function(e) {
            e.preventDefault();
            addNewSection('experience_section', 'experience');
        });
    
        // Function to add a new skill section
        document.getElementById('add_skill').addEventListener('click', function(e) {
            e.preventDefault();
            addNewSection('skills_section', 'skill');
        });
    
        // Function to add remove button listener
        function addRemoveListener(section) {
            section.querySelector('.remove-section').addEventListener('click', function() {
                section.remove();
            });
        }
    
        // Function to add new section dynamically (with empty fields)
        function addNewSection(sectionClass, sectionType) {
            let newSection = document.createElement('div');
            newSection.className = 'card section mb-3';
    
            // Generate new section with empty fields
            if (sectionType === 'education') {
                newSection.innerHTML = `
                    <div class="card-body row g-3">
                        <div class="col-sm-12">
                            <label for="degree_title" class="form-label">Degree<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="degree_title" name="degree_title[]" placeholder="Degree Title" required>
                            <div class="invalid-feedback">Valid degree is required.</div>
                        </div>
                        <div class="col-sm-12">
                            <label for="institute" class="form-label">Institute<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="institute" name="institute[]" placeholder="Institute" required>
                            <div class="invalid-feedback">Valid institute is required.</div>
                        </div>
                        <div class="col-6">
                            <label for="edu_start_date" class="form-label">Start date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edu_start_date" name="edu_start_date[]" required>
                            <div class="invalid-feedback">Start date is required.</div>
                        </div>
                        <div class="col-6">
                            <label for="edu_end_date" class="form-label">End date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edu_end_date" name="edu_end_date[]" required>
                            <div class="invalid-feedback">End date is required.</div>
                        </div>
                        <div class="col-12">
                            <label for="education_description" class="form-label">Description</label>
                            <textarea class="form-control" id="education_description" name="education_description[]" rows="6" placeholder="Description"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                        </div>
                    </div>`;
            } else if (sectionType === 'experience') {
                newSection.innerHTML = `
                    <div class="card-body row g-3">
                        <div class="col-sm-12">
                            <label for="job_title" class="form-label">Job Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="job_title" name="job_title[]" placeholder="Job Title" required>
                            <div class="invalid-feedback">Valid job title is required.</div>
                        </div>
                        <div class="col-sm-12">
                            <label for="organization" class="form-label">Organization<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="organization" name="organization[]" placeholder="Organization" required>
                            <div class="invalid-feedback">Valid organization is required.</div>
                        </div>
                        <div class="col-6">
                            <label for="job_start_date" class="form-label">Start date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="job_start_date" name="job_start_date[]" required>
                            <div class="invalid-feedback">Start date is required.</div>
                        </div>
                        <div class="col-6">
                            <label for="job_end_date" class="form-label">End date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="job_end_date" name="job_end_date[]" required>
                            <div class="invalid-feedback">End date is required.</div>
                        </div>
                        <div class="col-12">
                            <label for="job_description" class="form-label">Description</label>
                            <textarea class="form-control" id="job_description" name="job_description[]" rows="5" placeholder="Description"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                        </div>
                    </div>`;
            } else if (sectionType === 'skill') {
                newSection.innerHTML = `
                    <div class="card-body row g-3">
                        <div class="col-sm-12">
                            <label for="skills[]" class="form-label">Skill<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="skills" name="skills[]" placeholder="Enter a skill" required>
                            <div class="invalid-feedback">Please enter a valid skill.</div>
                        </div>
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                        </div>
                    </div>`;
            }
    
            document.querySelector(`.${sectionClass}`).appendChild(newSection);
            addRemoveListener(newSection);
        }
    
        // Initial remove button listeners
        document.querySelectorAll('.section').forEach(function(section) {
            addRemoveListener(section);
        });
    });
</script>
@endsection
