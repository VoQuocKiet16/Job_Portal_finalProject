@extends('front.layouts.app')

@section('main')
    <div class="container">
        <p class="text-center">For demo purposes, all inputs are pre-filled with values.</p>
        <div class="row g-5">
            <div class="col-md-12 col-lg-12">
                <form action="{{ route('save') }}" id="createform" class="needs-validation" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id" class="form-control" />

                    <!-- Personal details fields -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="mb-3">Personal details</h4>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="first_name" class="form-label">First name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder="John" value="Sattiyan" required>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="last_name" class="form-label">Last name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder="Doe" value="Selvarajah" required>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="profile_title" class="form-label">Profile title<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="text" class="form-control" id="profile_title" name="profile_title"
                                            placeholder="Web Developer" value="Web Developer" required>
                                        <div class="invalid-feedback">
                                            Your profile_title is required.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="about_me" class="form-label">Summary<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="about_me" name="about_me" rows="5"
                                        placeholder="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit sit blanditiis similique aliquam qui maiores iste sunt necessitatibus! Totam, id.">I am a skilled PHP backend web developer experienced in Bootstrap, Tailwind CSS, Astro JS, Shopify, WordPress, and Drupal. I excel at creating efficient and visually appealing web applications, utilizing tools like Zapier, Freshdesk, and Trello to streamline workflows. Continuously staying up-to-date with the latest web development trends, I am eager to take on new challenges and expand my skillset. Contact me for reliable and talented web development services.</textarea>
                                    <div class="invalid-feedback">
                                        Please enter your resume summary.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <!-- Contact details fields -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="mb-3">Contact details</h4>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="phone_number" class="form-label">Phone<span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="phone_number" name="phone_number"
                                        placeholder="0123456789" value="0143072966">
                                    <div class="invalid-feedback">
                                        Please enter a valid phone number.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="website" class="form-label">Website<span
                                            class="text-danger">*</span></label>
                                    <input type="url" class="form-control" id="website" name="website"
                                        placeholder="https://www.placeholder.com" value="https://www.sattiyans.com">
                                    <div class="invalid-feedback">
                                        Please enter a valid link.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="linkedin_link" class="form-label">LinkedIn<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="url" class="form-control" id="linkedin_link" name="linkedin_link"
                                            placeholder="https://www.linkedin.com/in/test" required
                                            value="https://www.linkedin.com/in/sattiyans">
                                        <div class="invalid-feedback">
                                            Your linkedin is required.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <!-- Education details fields -->
                    <h4 class="mb-0">Education details</h4>
                    <div class="education_section">
                        <div class="card section mb-3">
                            <div class="card-body row g-3">
                                <!-- Single education entry fields here -->
                                <div class="col-sm-12">
                                    <label for="degree_title" class="form-label">Degree<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="degree_title" name="degree_title[]"
                                        placeholder="Bachelor of Memes" required>
                                    <div class="invalid-feedback">
                                        Valid degree is required.
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label for="institute" class="form-label">Institute<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="institute" name="institute[]"
                                        placeholder="University of Memes" required>
                                    <div class="invalid-feedback">
                                        Valid institute is required.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="edu_start_date" class="form-label">Start date<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="date" class="form-control" id="edu_start_date"
                                            name="edu_start_date[]" required>
                                        <div class="invalid-feedback">
                                            Your start date is required.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="edu_end_date" class="form-label">End date<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="date" class="form-control" id="edu_end_date"
                                            name="edu_end_date[]" required>
                                        <div class="invalid-feedback">
                                            Your end date is required.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="education_description" class="form-label">Description<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="education_description" name="education_description[]" rows="6"
                                        placeholder="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit sit blanditiis similique aliquam qui maiores iste sunt necessitatibus! Totam, id."></textarea>
                                    <div class="invalid-feedback">
                                        Please enter your education description.
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <button id="add_education" class="btn btn-primary">Add education</button>
                    </div>

                    <hr class="my-4">
                    <!-- Experience details fields -->
                    <h4 class="mb-0">Experience details</h4>
                    <div class="experience_section">
                        <div class="card section mb-3">
                            <div class="card-body row g-3">
                                <!-- Single experience entry fields here -->
                                <div class="col-sm-12">
                                    <label for="job_title" class="form-label">Job Title<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="job_title" name="job_title[]"
                                        placeholder="Chief Meme Officer" required>
                                    <div class="invalid-feedback">
                                        Valid job title is required.
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label for="organization" class="form-label">Organization<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="organization" name="organization[]"
                                        placeholder="Supreme Memes Corp" required>
                                    <div class="invalid-feedback">
                                        Valid organization is required.
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="job_start_date" class="form-label">Start date<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="date" class="form-control" id="job_start_date"
                                            name="job_start_date[]" required>
                                        <div class="invalid-feedback">
                                            Your start date is required.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="job_end_date" class="form-label">End date<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="date" class="form-control" id="job_end_date"
                                            name="job_end_date[]" required>
                                        <div class="invalid-feedback">
                                            Your end date is required.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="job_description" class="form-label">Description<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="job_description" name="job_description[]" rows="5"
                                        placeholder="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit sit blanditiis similique aliquam qui maiores iste sunt necessitatibus! Totam, id."></textarea>
                                    <div class="invalid-feedback">
                                        Please enter your job description.
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                                </div>
                            </div>                        
                        </div>                
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <button id="add_experience" class="btn btn-primary">Add experience</button>
                    </div>
                    <hr class="my-4">
                    <!-- Add skills section -->
                    <h4 class="mb-0">Skills</h4>
                    <div class="skills_section">
                        <div class="card section mb-3">
                            <div class="card-body row g-3">
                                <div class="col-sm-12">
                                    <label for="skills[]" class="form-label">Skill<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="skills" name="skills[]" placeholder="Enter a skill" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid skill.
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <button id="add_skill" class="btn btn-primary">Add skill</button>
                    </div>
              
                    <hr class="my-4">
                    <button type="submit" class="w-100 btn btn-primary btn-lg mb-3">
                        Save <i class="fas fa-floppy-disk"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>

// document.addEventListener('DOMContentLoaded', function() {
//     // Function to add a new education section
//     document.getElementById('add_education').addEventListener('click', function(e) {
//         e.preventDefault();
//         var educationSection = document.querySelector('.education_section .section');
//         if (educationSection) {
//             var newEducationSection = educationSection.cloneNode(true);
//             newEducationSection.querySelectorAll('input, textarea').forEach(function(input) {
//                 input.value = ''; // Clear the values
//             });
//             document.querySelector('.education_section').appendChild(newEducationSection);
//             addRemoveListener(newEducationSection);
//         } else {
//             addNewSection('education_section', 'education');
//         }
//     });

//     // Function to add a new experience section
//     document.getElementById('add_experience').addEventListener('click', function(e) {
//         e.preventDefault();
//         var experienceSection = document.querySelector('.experience_section .section');
//         if (experienceSection) {
//             var newExperienceSection = experienceSection.cloneNode(true);
//             newExperienceSection.querySelectorAll('input, textarea').forEach(function(input) {
//                 input.value = ''; // Clear the values
//             });
//             document.querySelector('.experience_section').appendChild(newExperienceSection);
//             addRemoveListener(newExperienceSection);
//         } else {
//             addNewSection('experience_section', 'experience');
//         }
//     });

//     // Function to add a new skill section
//     document.getElementById('add_skill').addEventListener('click', function(e) {
//         e.preventDefault();
//         var skillSection = document.querySelector('.skills_section .section');
//         if (skillSection) {
//             var newSkillSection = skillSection.cloneNode(true);
//             newSkillSection.querySelectorAll('input').forEach(function(input) {
//                 input.value = ''; // Clear the values
//             });
//             document.querySelector('.skills_section').appendChild(newSkillSection);
//             addRemoveListener(newSkillSection);
//         } else {
//             addNewSection('skills_section', 'skill');
//         }
//     });

//     // Function to add remove button listener
//     function addRemoveListener(section) {
//         section.querySelector('.remove-section').addEventListener('click', function() {
//             section.remove();
//         });
//     }

//     // Function to add new section if none exist
//     function addNewSection(sectionClass, sectionType) {
//         var sectionDiv = document.createElement('div');
//         sectionDiv.className = 'card section mb-3';
//         sectionDiv.innerHTML = document.querySelector(`.${sectionClass} .section`).innerHTML;
//         sectionDiv.querySelectorAll('input, textarea').forEach(function(input) {
//             input.value = ''; // Clear the values
//         });
//         document.querySelector(`.${sectionClass}`).appendChild(sectionDiv);
//         addRemoveListener(sectionDiv);
//     }

//     // Initial remove button listeners
//     document.querySelectorAll('.section').forEach(function(section) {
//         addRemoveListener(section);
//     });
// });

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

    // Function to add new section
    function addNewSection(sectionClass, sectionType) {
        let sectionTemplate = document.querySelector(`.${sectionClass} .section`);
        let newSection = document.createElement('div');
        newSection.className = 'card section mb-3';

        // Check if section template exists
        if (sectionTemplate) {
            newSection.innerHTML = sectionTemplate.innerHTML;
        } else {
            // Create a new section with the appropriate fields if no template exists
            if (sectionType === 'education') {
                newSection.innerHTML = `
                    <div class="card-body row g-3">
                        <div class="col-sm-12">
                            <label for="degree_title" class="form-label">Degree<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="degree_title" name="degree_title[]" placeholder="Bachelor of Memes" required>
                            <div class="invalid-feedback">Valid degree is required.</div>
                        </div>
                        <div class="col-sm-12">
                            <label for="institute" class="form-label">Institute<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="institute" name="institute[]" placeholder="University of Memes" required>
                            <div class="invalid-feedback">Valid institute is required.</div>
                        </div>
                        <div class="col-6">
                            <label for="edu_start_date" class="form-label">Start date<span class="text-danger">*</span></label>
                            <div class="input-group has-validation">
                                <input type="date" class="form-control" id="edu_start_date" name="edu_start_date[]" required>
                                <div class="invalid-feedback">Your start date is required.</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="edu_end_date" class="form-label">End date<span class="text-danger">*</span></label>
                            <div class="input-group has-validation">
                                <input type="date" class="form-control" id="edu_end_date" name="edu_end_date[]" required>
                                <div class="invalid-feedback">Your end date is required.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="education_description" class="form-label">Description<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="education_description" name="education_description[]" rows="6" placeholder="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit sit blanditiis similique aliquam qui maiores iste sunt necessitatibus! Totam, id."></textarea>
                            <div class="invalid-feedback">Please enter your education description.</div>
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
                            <input type="text" class="form-control" id="job_title" name="job_title[]" placeholder="Chief Meme Officer" required>
                            <div class="invalid-feedback">Valid job title is required.</div>
                        </div>
                        <div class="col-sm-12">
                            <label for="organization" class="form-label">Organization<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="organization" name="organization[]" placeholder="Supreme Memes Corp" required>
                            <div class="invalid-feedback">Valid organization is required.</div>
                        </div>
                        <div class="col-6">
                            <label for="job_start_date" class="form-label">Start date<span class="text-danger">*</span></label>
                            <div class="input-group has-validation">
                                <input type="date" class="form-control" id="job_start_date" name="job_start_date[]" required>
                                <div class="invalid-feedback">Your start date is required.</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="job_end_date" class="form-label">End date<span class="text-danger">*</span></label>
                            <div class="input-group has-validation">
                                <input type="date" class="form-control" id="job_end_date" name="job_end_date[]" required>
                                <div class="invalid-feedback">Your end date is required.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="job_description" class="form-label">Description<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="job_description" name="job_description[]" rows="5" placeholder="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit sit blanditiis similique aliquam qui maiores iste sunt necessitatibus! Totam, id."></textarea>
                            <div class="invalid-feedback">Please enter your job description.</div>
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

