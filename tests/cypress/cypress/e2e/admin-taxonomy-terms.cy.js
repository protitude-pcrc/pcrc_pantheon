describe('Loads routes and tests', () => {
  it('Test pages as admin', () => {
    cy.fixture("login-data.json").then((loginData) => {
      loginData.users.forEach((user) => {
        if (user.username === 'therealrick') {
          cy.loginAs(user.username, user.password);

          cy.visit('admin/structure/taxonomy/manage/category/overview');
          cy.contains('Category');

          cy.visit('admin/structure/taxonomy/manage/font_classification/overview');
          ['Classification', 'display', 'handwriting', 'monospace', 'sans-serif', 'serif'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/conditions_studied/overview');
          ['Conditions Studied', 'Acute Kidney Injury', 'Amyotrophic Lateral Sclerosis (ALS)', 'Bacterial Endocarditis', 'Bladder (including Urethral) Cancer', 'Brain Cancer', 'Breast Cancer', 'Bronchiectasis', 'Cirrhosis (non-viral)', 'Colon, Rectal, or Anal cancer', 'Connective Tissue Disease', 'COPD (including emphysema and chronic bronchitis)', 'Coronary artery Disease (including Myocardial Infarction)', 'Cystic Fibrosis', 'Dementia', 'Diabetes (uncomplicated)', 'Diabetes (with end organ damage)', 'End-Stage Renal Disease', 'Head and Neck Cancer', 'Heart Failure', 'Hemi- or Para-plegia', 'HIV/AIDS', 'Ischemic colitis (including bowel perforation)', 'Leukemia (including MDS)', 'Lung (non-small cell)', 'Lung (small cell)', 'Lymphoma', 'Melanoma', 'Multiple contributing Conditions', 'Multiple Myeloma (including amyloidosis)', 'Multiple sclerosis', 'Osteomyelitis', 'Other Cancer', 'Other Cardiovascular Disease', 'Other GI Disease', 'Other Infectious Disease', 'Other Neurological Disease', 'Other Pulmonary Disease', 'Other Renal Disease', 'Other upper GI (liver, gastric esophageal, carcinoid, etc.) Cancer', 'Ovarian/peritoneal Cancer', 'Pancreatic Cancer', 'Parkinson’s Disease', 'Peripheral Vascular Disease', 'Pneumonia', 'Prostate Cancer', 'Pulmonary Fibrosis, ILD, and other restrictive lung disease', 'Pulmonary Hypertension', 'Renal Cancer', 'Restrictive Heart Disease', 'Severe debility', 'Severe GI bleed', 'Stroke (hemorrhagic)', 'Stroke (ischemic/embolic)', 'Thyroid Cancer', 'Traumatic Brain Injury (TBI)', 'Ulcer Disease', 'Uterine, Cervical, or Vaginal Cancer', 'Valvular Heart Disease', 'Viral Hepatitis/Cirrhosis'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/data_types/overview');
          ['Data Types', 'Mixed Methods', 'Qualitative', 'Quantitative'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/directory_lists/overview');
          ['Directory Lists', 'Membership Roster', 'Organizational Leads'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/news_types/overview');
          ['News Types', 'Announcements', 'Cores and Centers', 'Funding', 'In the News', 'Newsletters', 'PCRC Testimonials', 'Uncategorized'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/number_of_study_sites/overview');
          ['Number of Study Sites', '1', '2 – 4', '5 – 10', '11 - 15', '> 15'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/organizations/overview');
          ['Organizations', 'Advocate Aurora Health', 'Akron Children\'s Hospital', 'Albert Einstein College of Medicine', 'Aspire Healthcare', 'Atrium Health', 'Augusta University', 'Augusta University-Children\'s Hospital of Georgia', 'Avera eCare SeniorCare', 'Baylor College of Medicine', 'Baylor University', 'Ben Gurion University', 'Beth Israel Deaconess Medical Center', 'Binghamton University', 'Blue Cross Blue Shield of Massachusetts', 'Bluegrass Care Navigators', 'Boise State University', 'Boston Children\'s Hospital', 'Boston College', 'Boston University', 'Bowling Green State University', 'Brigham and Women\'s Hospital', 'Brighton and Sussex Medical School', 'Brown University', 'California Health Sciences University', 'California State University, Los Angeles', 'Capital Caring Health & Worldwide Hospice Palliative Care Alliance', 'Care Dimensions', 'Care Partners Hospice / Mission Health', 'Case Western Reserve University', 'Cedars-Sinai Medical Center', 'Central Arkansas Veterans Healthcare System', 'Central Michigan University', 'Children\'s Hospital Colorado', 'Children\'s Hospital Los Angeles', 'Children\'s Hospital of Philadelphia', 'Children\'s Mercy Kansas', 'Children\'s National Hospital', 'Children’s Hospital of Wisconsin', 'City of Hope Medical Center', 'City University of New York', 'Clayton State University', 'Cleveland Clinic', 'Cleveland Clinic Foundation', 'Cohen Children\'s Medical Center of Northwell Health', 'Colorado State University', 'Columbia University', 'Compassus', 'Concord Centre for Palliative Care', 'Connecticut Children\'s Medical Center', 'Corewell Health', 'Cottage Health', 'Creighton University', 'Dana-Farber Cancer Institute', 'Darthmouth-Hitchcock', 'Dartmouth College', 'Denver Health', 'Duke University', 'Duke-National University of Singapore', 'Durham VA Health System', 'East Carolina University', 'Einstein Healthcare Network', 'Eisenhower Medical Center', 'Emory University', 'FHI 360', 'Florida Atlantic University', 'Florida State University', 'Fordham University', 'Four Seasons', 'Fox Chase Cancer Center', 'Fred Hutchinson Cancer Research Center', 'George Washington University', 'Georgetown University Medical Center', 'Goldfarb School of Nursing at Barnes Jewish College', 'Hackensack Meridian', 'Harvard University', 'Hospital for Sick Children', 'Hunter College', 'Indiana University', 'Intermountain\'s Primary Children\'s Hospital', 'JH Bayview Medical Center', 'John D Dingell VA Medical Center', 'johns hopkins', 'Johns Hopkins University', 'Johns Hopkins University School of Nursing', 'Joliot Curie Institute / Aristide Le Dantec Hospital', 'JPS Health Network', 'Kaiser of Northern California', 'Kaiser Permanente Colorado', 'Kaiser Permanente Northwest', 'Kaiser Permanente Washington Health Research Institute', 'Kennesaw State University', 'Kent State University', 'LeadingAge', 'Levine Cancer Institute', 'M Health Fairview', 'Maine Medical Center', 'Marquette University and Children\'s Wisconsin', 'Massachusetts General Hospital', 'Mayo Clinic', 'Medical College of Wisconsin', 'MedStar Health / Georgetown University'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/participant_age/overview');
          ['Participant Age', 'Adult', 'Geriatric', 'Pediatric'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/participant_ethnicity_collected/overview');
          ['Participant Ethnicity Collected', 'No', 'Yes'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/participant_race/overview');
          ['Participant Race', '< 25% Non-Hispanic White', '≥ 25% Non-Hispanic White'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/participant_sex/overview');
          ['Participant Sex', 'Both male and female participants', 'Only female participants', 'Only male participants'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/participant_types/overview');
          ['Participant Types', 'Caregiver', 'Health Care Provider', 'Patient'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/request_types/overview');
          ['Request Types', 'Approved Request', 'Request Deemed Not Feasible with Available Data'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/study_design/overview');
          ['Study Design', 'Intervention', 'Observational – cross-sectional', 'Observational – longitudinal'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/study_setting/overview');
          ['Study Setting', 'Assisted Living', 'Clinic-Ambulatory', 'Domiciliary-Boarding Home', 'Home', 'Hospital', 'Nursing Home', 'Other Setting'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/study_types/overview');
          ['Study Types', 'PCRC Pilot Funded Studies', 'PCRC Supported Trials'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/therapeutic_areas/overview');
          ['Therapeutic Areas', 'Cancers', 'Cardiovascular', 'Gastrointestinal', 'Hepatic', 'Infectious', 'Multi-Systemic', 'Neurologic/Neurodegenerative', 'Pulmonary', 'Renal'].forEach(item => {
            cy.contains(item);
          });

          cy.visit('admin/structure/taxonomy/manage/total_enrollment/overview');
          ['Total Enrollment', '< 50', '50 – 99', '100 – 199', '200 – 299', '300 – 399', '400 – 499', '≥ 500'].forEach(item => {
            cy.contains(item).should('be.visible');
          });

        }
      })
    })
  });
});
