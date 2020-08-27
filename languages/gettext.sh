# Change every instance of pmpro-addon-slug below to match your actual plugin slug
#---------------------------
# This script generates a new pmpro.pot file for use in translations.
# To generate a new pmpro-reason-for-cancelling.pot, cd to the main /pmpro-reason-for-cancelling/ directory,
# then execute `languages/gettext.sh` from the command line.
# then fix the header info (helps to have the old pmpro.pot open before running script above)
# then execute `cp languages/pmpro-reason-for-cancelling.pot languages/pmpro-reason-for-cancelling.po` to copy the .pot to .po
# then execute `msgfmt languages/pmpro-reason-for-cancelling.po --output-file languages/pmpro-reason-for-cancelling.mo` to generate the .mo
#---------------------------
echo "Updating pmpro-reason-for-cancelling.pot... "
xgettext -j -o languages/pmpro-reason-for-cancelling.pot \
--default-domain=pmpro-reason-for-cancelling \
--language=PHP \
--keyword=_ \
--keyword=__ \
--keyword=_e \
--keyword=_ex \
--keyword=_n \
--keyword=_x \
--sort-by-file \
--package-version=1.0 \
--msgid-bugs-address="info@paidmembershipspro.com" \
$(find . -name "*.php")
echo "Done!"