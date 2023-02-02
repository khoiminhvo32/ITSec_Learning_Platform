from flask import Blueprint, render_template

from CTFd.utils import config
from CTFd.utils.config.visibility import solutions_visible
from CTFd.utils.decorators.visibility import check_solutions_visibility
from CTFd.utils.helpers import get_infos

from CTFd.utils.user import is_admin

solutions = Blueprint("solutions", __name__)


@solutions.route("/solutions")
@check_solutions_visibility
def listing():
    infos = get_infos()

    if is_admin() is True and solutions_visible() is False:
        infos.append("Solutions are not currently visible to users")

    return render_template("solutions.html")
